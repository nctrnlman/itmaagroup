<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Comment;
use App\Models\Employee;
use App\Models\Ticketing;
use App\Models\AccessMenu;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\SendWhatsAppMessageJob;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Http;

class ITHelpdeskController extends Controller
{

    public function index()
    {
        $userId = session('user')->idnik;
        $userLokasi = session('user')->lokasi;

        $usersIT = AccessMenu::join('user', 'access_menu.idnik', '=', 'user.idnik')
            ->whereIn('access_menu.access_type', ['it', 'admin'])
            ->get();

        $isAdmin = AccessMenu::where('idnik', $userId)
            ->whereIn('access_type', ['admin'])
            ->exists();


        $isIT = AccessMenu::where('idnik', $userId)
            ->whereIn('access_type', ['it'])
            ->exists();

        $allUsers = Employee::all();

        if ($isAdmin) {
            $tickets = Ticketing::join('user', 'ticketing.id_nik_request', '=', 'user.idnik')
                ->select('ticketing.*', 'user.*')
                ->orderByDesc('start_date') // Mengurutkan berdasarkan tanggal terbaru lebih dulu
                ->get();
            // ->orderByRaw("FIELD(status_tiket, 'Pending', 'Process', 'Closed', 'Rejected')")
            // ->orderBy('start_date', 'desc')
            // ->get();
            // dd($tickets);

            $totalTickets = $tickets->count();
            $pendingTickets = $tickets->where('status_tiket', 'Pending')->count();
            $processTickets = $tickets->where('status_tiket', 'Process')->count();
            $closedTickets = $tickets->where('status_tiket', 'Closed')->count();
        } else if ($isIT) {
            $tickets = Ticketing::join('user', 'ticketing.id_nik_request', '=', 'user.idnik')
                ->select('ticketing.*', 'user.*')
                ->where('user.lokasi', $userLokasi) // Filter tiket berdasarkan lokasi sesi 'user_lokasi'
                ->orderByRaw("FIELD(status_tiket, 'Pending', 'Process', 'Closed', 'Rejected')")
                ->orderBy('start_date', 'desc')
                ->get();

            $totalTickets = $tickets->count();
            $pendingTickets = $tickets->where('status_tiket', 'Pending')->count();
            $processTickets = $tickets->where('status_tiket', 'Process')->count();
            $closedTickets = $tickets->where('status_tiket', 'Closed')->count();
        } else {
            $tickets = Ticketing::where('id_nik_request', $userId)
                ->orderByRaw("FIELD(status_tiket, 'Pending', 'Process', 'Closed', 'Rejected')")
                ->orderBy('start_date', 'desc')
                ->get();

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
                'wa' => 'required',
            ]);

            if (session('user')['access_type'] === 'Admin' || session('user')['access_type'] === 'IT') {
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
                $uuid = str_pad(mt_rand(0, 999), 3, '0', STR_PAD_LEFT);
                $idHelpdesk = 'IT' . $year . $currentDate->format('md') . substr($idnik, -3) . $uuid;

                $existingTask = Ticketing::where('id_tiket', $idHelpdesk)->first();

                if (!$existingTask) {
                    $generatedId = true;
                }
            }


            $filename1 = null;
            if ($request->hasFile('lampiran1')) {
                $lampiran1 = $request->file('lampiran1');
                $filename1 = $idHelpdesk . '_' . $lampiran1->getClientOriginalName();
                $lampiran1->storeAs('public/ithelpdesk', $filename1);
            }

            $filename2 = null;
            if ($request->hasFile('lampiran2')) {
                $lampiran2 = $request->file('lampiran2');
                $filename2 = $idHelpdesk . '_' . $lampiran2->getClientOriginalName();
                $lampiran2->storeAs('public/ithelpdesk', $filename2);
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
            $message = "Halo " . $namaEmployee . "!\n\nTicketing dengan ID #" . $idHelpdesk . " Anda sudah berhasil dibuat dengan status 'Pending'\n\nTerima kasih telah menggunakan layanan kami. Jangan lupa untuk selalu cek Employee Information Portal (EIP) untuk informasi selanjutnya. Jika Anda memiliki pertanyaan lebih lanjut atau membutuhkan bantuan, jangan ragu untuk menghubungi tim IT kami.\n\nTerima kasih!\n\nInfo lebih lanjut tentang tiket ini: " . $link;
            SendWhatsAppMessageJob::dispatch($target, $message)->onQueue('whatsapp');

            Alert::success('Success', 'Ticket created successfully!');
            return redirect()->back();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->getMessageBag();

            if ($errors->has('desc')) {
                Alert::error('Error', 'Please insert description.');
                return redirect()->back();
            } elseif ($errors->has('wa')) {
                Alert::error('Error', 'Please insert whatsapp number.');
                return redirect()->back();
            } else {
                Alert::error('Error', 'Failed to create Ticket. Please try again.');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to create Ticket. Please try again.');
            return redirect()->back();
        }
    }

    public function detailTicket($id_tiket)
    {
        $ticket = Ticketing::join('user', 'ticketing.id_nik_request', '=', 'user.idnik')
            ->join('login', 'login.idnik', '=', 'ticketing.id_nik_request')
            ->select('ticketing.*', 'login.*', 'user.*')
            ->where('ticketing.id_tiket', $id_tiket)
            ->first();


        $usersIT = AccessMenu::join('user', 'access_menu.idnik', '=', 'user.idnik')
            ->where('access_menu.access_type', 'it')
            ->get();

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
                Alert::error('Error', 'Ticket not found');
                return redirect()->back();
            }

            if ($request->input('status_tiket') == 'Closed') {
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


            $message = "Halo " . $namaEmployee . "!\n\nTicketing dengan ID #" . $id_tiket . "sudah berhasil diupdate dengan status " . $statusTiket . " .\n\nTerima kasih telah menggunakan layanan kami. Jangan lupa untuk selalu cek Employee Information Portal (EIP) untuk informasi selanjutnya. Jika Anda memiliki pertanyaan lebih lanjut atau membutuhkan bantuan, jangan ragu untuk menghubungi tim IT kami.\n\nTerima kasih!\n\nInfo lebih lanjut tentang tiket ini: \n" . $link;

            SendWhatsAppMessageJob::dispatch($target, $message)->onQueue('whatsapp');
            Alert::success('Success', 'Update Successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Error', 'Error occurred during update');
            return redirect()->back();
        }
    }

    public function delete(Request $request, $id_tiket)
    {
        try {
            $ticket = Ticketing::find($id_tiket);

            if (!$ticket) {
                Alert::error('Error', 'Ticket not found');
                return redirect()->back();
            }

            $ticket->delete();

            Alert::success('Success', 'Ticket deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Error', 'Error occurred during ticket deletion');
            return redirect()->back();
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
                $uuid = sprintf('%03d', $uuid);
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

            Alert::success('Success', 'Comment added successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Error', 'An error occurred while adding the comment');
            return redirect()->back();
        }
    }
}
