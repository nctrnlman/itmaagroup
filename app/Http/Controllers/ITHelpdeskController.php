<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Comment;
use App\Models\Employee;
use App\Models\Ticketing;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\SendWhatsAppMessageJob;
use Illuminate\Support\Facades\Http;

class ITHelpdeskController extends Controller
{

    public function index()
    {
        $userRole = session('user')->position;
        $usersIT = Employee::where(function ($query) {
            $query->where('position', 'like', '% IT%')
                  ->orWhere('position', 'like', 'IT %')
                  ->orWhere('position', 'like', '% IT %')
                  ->orWhere('position', '=', 'IT');
        })->get();
        $allUsers = Employee::all();

        if (strpos($userRole, 'IT') !== false) {
            $tickets = Ticketing::join('user', 'ticketing.id_nik_request', '=', 'user.idnik')
                ->select('ticketing.*', 'user.*')
                ->get();

            $totalTickets = $tickets->count();
            $pendingTickets = $tickets->where('status_tiket', 'Pending')->count();
            $processTickets = $tickets->where('status_tiket', 'Process')->count();
            $closedTickets = $tickets->where('status_tiket', 'Closed')->count();
        } else {
            $userId = session('user')->idnik;
            $tickets = Ticketing::where('id_nik_request', $userId)->get();
            $totalTickets = $tickets->count();
            $pendingTickets = $tickets->where('status_tiket', 'Pending')->count();
            $processTickets = $tickets->where('status_tiket', 'Process')->count();
            $closedTickets = $tickets->where('status_tiket', 'Closed')->count();
        }
        
        return view('it-helpdesk', [
            'tickets' => $tickets, 'totalTickets' => $totalTickets,
            'pendingTickets' => $pendingTickets,
            'processTickets' => $processTickets,
            'closedTickets' => $closedTickets,
            'usersIT' => $usersIT,
            'allUsers' => $allUsers
        ]);
    }

    public function insert(Request $request)
    {
        try {
            $request->validate([
                'desc' => 'required',
                'lampiran1' => 'required|file',
                'wa' => 'required',
            ]);
            $userRole = session('user')->position;

            if (strpos($userRole, 'IT') !== false) {
                $id_nik_request = $request->input('request');
            } else {
                $id_nik_request = session('user')->idnik;
            }

            $generatedId = false;
            $idHelpdesk = '';

            while (!$generatedId) {
                $currentDate = Carbon::now();
                $year = substr($currentDate->year, -2);
                $idnik =  $id_nik_request;
                $generatedUuid = Str::uuid();
                $parts = explode("-", $generatedUuid);
                $numericUuid = implode("", array_filter($parts, 'is_numeric'));
                $uuid = substr($numericUuid, 0, 3);
                $idHelpdesk = 'IT' . $year . $currentDate->format('md') . substr($idnik, -3) . $uuid;

                $existingTask = Ticketing::where('id_tiket', $idHelpdesk)->first();

                if (!$existingTask) {

                    $generatedId = true;
                }
            }

            $lampiran1 = $request->file('lampiran1');
            $filename1 = $idHelpdesk . '_' . $lampiran1->getClientOriginalName();
            $lampiran1->storeAs('public/uploads/ithelpdesk', $filename1);

            if ($request->hasFile('lampiran2')) {
                $lampiran2 = $request->file('lampiran2');
                $filename2 = $idHelpdesk . '_' . $lampiran2->getClientOriginalName();
                $lampiran2->storeAs('public/uploads/ithelpdesk', $filename2);
            } else {
                $filename2 = null;
            }
            $Ticketing = new Ticketing();
            $Ticketing->id_tiket = $idHelpdesk;
            $Ticketing->id_nik_request =  $id_nik_request;
            $Ticketing->start_date = $currentDate;
            $Ticketing->disc_keluhan = $request->desc;
            $Ticketing->lampiran1 = $filename1;
            $Ticketing->lampiran2 = $filename2;
            $Ticketing->whatsapp = $request->wa;
            $Ticketing->save();

            $employee = Employee::where('idnik', $id_nik_request)->first();
            $namaEmployee = $employee ? $employee->nama : 'Bapak/Ibu';
            $link = route('it-helpdesk.detail', ['id_tiket' => $idHelpdesk]);

            $target = $request->wa;
            $message = "Halo " . $namaEmployee . "!\n\nTicketing dengan ID #". $idHelpdesk ." Anda sudah berhasil dibuat dengan status 'Pending'\n\nTerima kasih telah menggunakan layanan kami. Jangan lupa untuk selalu cek Employee Information Portal (EIP) untuk informasi selanjutnya. Jika Anda memiliki pertanyaan lebih lanjut atau membutuhkan bantuan, jangan ragu untuk menghubungi tim IT kami.\n\nTerima kasih!\n\nInfo lebih lanjut tentang tiket ini: " . $link;
            SendWhatsAppMessageJob::dispatch($target, $message)->onQueue('whatsapp');
            
            return redirect()->back()->with('success', 'Ticket created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create Ticket. Please try again.');
        }
    }

    public function detailTicket($id_tiket)
    {
        $ticket = Ticketing::join('user', 'ticketing.id_nik_request', '=', 'user.idnik')
            ->join('login', 'login.idnik', '=', 'ticketing.id_nik_request')
            ->select('ticketing.*', 'login.*', 'user.*')
            ->where('ticketing.id_tiket', $id_tiket)
            ->first();

            $usersIT = Employee::where(function ($query) {
                $query->where('position', 'like', '% IT%')
                      ->orWhere('position', 'like', 'IT %')
                      ->orWhere('position', 'like', '% IT %')
                      ->orWhere('position', '=', 'IT');
            })->get();
            
        $comments = Comment::join('user', 'komentar.nik_komen', '=', 'user.idnik')
            ->where('komentar.id_tiket', $id_tiket)
            ->select('komentar.*', 'user.*')
            ->orderBy('komentar.datetime', 'asc')
            ->get();

        return view('it-helpdesk-detail', ['ticket' => $ticket, 'usersIT' => $usersIT, 'comments' => $comments]);
    }

    public function update(Request $request, $id_tiket)
    {
        try {
            $validatedData = $request->validate([
                'justification' => 'required',
                'actionNote' => 'required',
            ]);

            $ticket = Ticketing::find($id_tiket);


            if (!$ticket) {
                return redirect()->back()->with('error', 'Ticket not found');
            }


            if ($ticket->status_tiket == 'Closed') {
                $ticket->end_date = Carbon::now();
            }

            $ticket->justification = $validatedData['justification'];
            $ticket->action_note = $validatedData['actionNote'];
            $ticket->status_tiket = $request->input('status_tiket');
            $ticket->kategori_tiket = $request->input('kategori_tiket');
            $ticket->nik_pic = $request->input('nik_pic');
            $ticket->save();

            $ticketEmployee = Employee::where('idnik', $ticket->id_nik_request)->first();
            $namaEmployee = $ticketEmployee ? $ticketEmployee->nama : 'Bapak/Ibu';
            $link = route('it-helpdesk.detail', ['id_tiket' => $id_tiket]);
            $statusTiket = $request->status_tiket;
            
            $target = $ticket->whatsapp;


if ($statusTiket === 'Closed') {
    $message = "Halo " . $namaEmployee . "!\n\nTicketing dengan ID #" . $id_tiket . " dan status " . $statusTiket . " sudah berhasil diupdate dan ditutup.\n\nTerima kasih telah menggunakan layanan kami. Jangan lupa untuk selalu cek Employee Information Portal (EIP) untuk informasi selanjutnya. Jika Anda memiliki pertanyaan lebih lanjut atau membutuhkan bantuan, jangan ragu untuk menghubungi tim IT kami.\n\nTerima kasih!\n\nInfo lebih lanjut tentang tiket ini: \n" . $link;
} else {
    $message = "Halo " . $namaEmployee . "!\n\nTicketing dengan ID #" . $id_tiket . " dan status " . $statusTiket . " sudah berhasil diupdate.\n\nTerima kasih telah menggunakan layanan kami. Jangan lupa untuk selalu cek Employee Information Portal (EIP) untuk informasi selanjutnya. Jika Anda memiliki pertanyaan lebih lanjut atau membutuhkan bantuan, jangan ragu untuk menghubungi tim IT kami.\n\nTerima kasih!\n\nInfo lebih lanjut tentang tiket ini: \n" . $link;
}

SendWhatsAppMessageJob::dispatch($target, $message)->onQueue('whatsapp');

            return redirect()->back()->with('success', 'Update Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error occurred during update');
        }
    }

    public function delete(Request $request, $id_tiket)
    {
        try {
            $ticket = Ticketing::find($id_tiket);

            if (!$ticket) {
                return redirect()->back()->with('error', 'Ticket not found');
            }

            $ticket->delete();

            return redirect()->route('it-helpdesk')->with('success', 'Ticket deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error occurred during ticket deletion');
        }
    }


    public function komentar(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'keterangan_komen' => 'required',
                'id_tiket' => 'required',
            ]);
        
            $generatedId = false;
            $idComment = '';
        
            while (!$generatedId) {
                $currentDate = Carbon::now();
                $year = substr($currentDate->year, -2);
                $idnik = session('user')->idnik;
                $generatedUuid = Str::uuid();
                $parts = explode("-", $generatedUuid);
                $numericUuid = implode("", array_filter($parts, 'is_numeric'));
                $uuid = substr($numericUuid, 0, 3);
                $idComment = 'CMT' . $year . $currentDate->format('md') . substr($idnik, -3) . $uuid;
        
                $existingTask = Comment::where('id_komen_tiket', $idComment)->exists();
        
                if (!$existingTask) {
                    $generatedId = true;
                }
            }
        
            $comment = new Comment();
            $comment->id_komen_tiket = $idComment;
            $comment->id_tiket = $request->id_tiket;
            $comment->nik_komen = $idnik;
            $comment->datetime = Carbon::now('Asia/Jakarta');
            $comment->keterangan_komen = $validatedData['keterangan_komen'];
        
            $comment->save();
        
            return redirect()->back()->with('success', 'Komentar berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan komentar');
        }
        
    }
}
