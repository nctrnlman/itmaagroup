<?php

namespace App\Http\Controllers\Facilities;

use Carbon\Carbon;
use App\Models\Comment;
use App\Models\Employee;
use App\Models\AccessMenu;
use Illuminate\Http\Request;
use App\Models\Facilities\Other;
use App\Http\Controllers\Controller;
use App\Jobs\SendWhatsAppMessageJob;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class OtherFacilitiesController extends Controller
{
    public function index()
    {
        $userId = session('user')->idnik;
        $accessType = session('user')->access_type;

        $usersGA = AccessMenu::join('user', 'access_menu.idnik', '=', 'user.idnik')
            ->whereIn('access_menu.access_type', ['GA Other Facilities', 'admin'])
            ->get();

        $isAdmin = AccessMenu::where('idnik', $userId)
            ->whereIn('access_type', ['admin'])
            ->exists();


        $allUsers = Employee::all();

        if ($isAdmin || $accessType === 'GA Other Facilities') {
            $tickets = Other::join('user', 'ga_other_facilities.nik_request', '=', 'user.idnik')
                ->select('ga_other_facilities.*', 'user.*')
                ->orderByRaw("FIELD(status, 'Pending', 'Process', 'Closed', 'Rejected')")
                ->orderBy('start_date', 'desc')
                ->get();

            $totalTickets = $tickets->count();
            $pendingTickets = $tickets->where('status', 'Pending')->count();
            $processTickets = $tickets->where('status', 'Process')->count();
            $closedTickets = $tickets->where('status', 'Closed')->count();
        } else {
            $tickets = Other::where('nik_request', $userId)
                ->orderByRaw("FIELD(status, 'Pending', 'Process', 'Closed', 'Rejected')")
                ->orderBy('start_date', 'desc')
                ->get();
            $totalTickets = $tickets->count();
            $pendingTickets = $tickets->where('status', 'Pending')->count();
            $processTickets = $tickets->where('status', 'Process')->count();
            $closedTickets = $tickets->where('status', 'Closed')->count();
        }



        return view('facilities.other-facilities', [
            'tickets' => $tickets, 'totalTickets' => $totalTickets,
            'pendingTickets' => $pendingTickets,
            'processTickets' => $processTickets,
            'closedTickets' => $closedTickets,
            'usersGA' => $usersGA,
            'allUsers' => $allUsers
        ]);
    }

    public function insert(Request $request)
    {
        try {
            $request->validate([
                'desc' => 'required',
                'wa' => 'required',
                'request' => 'required',
            ]);


            $nik_request = $request->input('request');

            $generatedId = false;
            $idGA = '';

            while (!$generatedId) {

                $currentDate = Carbon::now();
                $year = substr($currentDate->year, -2);
                $idnik =  $nik_request;
                $uuid = str_pad(mt_rand(0, 999), 3, '0', STR_PAD_LEFT);

                $idGA = 'RP' . $year . $currentDate->format('md') . substr($idnik, -3) . $uuid;

                $existingTask = Other::where('id_ga_other_facilities', $idGA)->first();

                if (!$existingTask) {
                    $generatedId = true;
                }
            }


            $filename1 = null;
            if ($request->hasFile('lampiran1')) {
                $lampiran1 = $request->file('lampiran1');
                $filename1 = $idGA . '_' . $lampiran1->getClientOriginalName();
                $lampiran1->storeAs('public/gaOther', $filename1);
            }


            $Other = new Other();
            $Other->id_ga_other_facilities = $idGA;
            $Other->nik_request =  $nik_request;
            $Other->start_date = $currentDate;
            $Other->description = $request->desc;
            $Other->category = 'Other Facilities Request';
            $Other->status = 'Pending';
            $Other->file = $filename1;
            $Other->whatsapp = $request->wa;
            $Other->save();

            $employee = Employee::where('idnik', $nik_request)->first();


            $namaEmployee = $employee ? $employee->nama : 'Bapak/Ibu';

            $link = route('other-facilities.detail', ['id_tiket' => $idGA]);

            $target = $request->wa;
            $message = "Halo " . $namaEmployee . ",\n\nTiket dengan ID #" . $idGA . " Anda telah berhasil dibuat dengan status 'OPEN'.\n\nThank you for your time to fill and support EIP (Employee Information Portal) for request System, We will respond to your request, please wait we will process according to the queue !! :) \n
Terima kasih atas waktunya untuk mengisi dan mendukung sistem request EIP, kami akan memproses permintaan anda, mohon kesediaannya untuk menunggu sesuai dengan antrian !! \n
Jika Anda memiliki pertanyaan lebih lanjut atau membutuhkan bantuan, jangan ragu untuk menghubungi tim General Affairs kami: " . $link . "\n\nTerima kasih! :)";
            SendWhatsAppMessageJob::dispatch($target, $message)->onQueue('whatsapp');

            Alert::success('Success', 'Ticket created successfully!');
            return redirect()->back();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->getMessageBag();

            if ($errors->has('desc')) {
                Alert::error('Error', 'Please insert Description.');
                return redirect()->back();
            } elseif ($errors->has('wa')) {
                Alert::error('Error', 'Please insert Whatsapp number.');
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
        $ticket = Other::join('user', 'ga_other_facilities.nik_request', '=', 'user.idnik')
            ->join('login', 'login.idnik', '=', 'ga_other_facilities.nik_request')
            ->select('ga_other_facilities.*', 'login.*', 'user.*')
            ->where('ga_other_facilities.id_ga_other_facilities', $id_tiket)
            ->first();


        if ($ticket && $ticket->category === 'Other Facilities Request') {
            $usersGA = AccessMenu::join('user', 'access_menu.idnik', '=', 'user.idnik')
                ->whereIn('access_menu.access_type', ['GA Other Facilities'])
                ->get();
        } else {

            $usersGA = collect();
        }

        $comments = Comment::join('user', 'komentar.nik_komen', '=', 'user.idnik')
            ->where('komentar.id_tiket', $id_tiket)
            ->select('komentar.*', 'user.*')
            ->orderBy('komentar.datetime', 'asc')
            ->get();

        return view('facilities.other-facilities-detail', ['ticket' => $ticket, 'usersGA' => $usersGA, 'comments' => $comments]);
    }

    public function update(Request $request, $id_tiket)
    {
        try {
            $ticket = Other::find($id_tiket);


            if (!$ticket) {
                Alert::error('Error', 'Ticket not found');
                return redirect()->back();
            }

            if ($request->input('status') == 'Closed') {
                $ticket->end_date = Carbon::now();
            }

            $ticket->status = $request->input('status');
            $ticket->nik_pic = $request->input('nik_pic');
            $ticket->save();

            $ticketEmployee = Employee::where('idnik', $ticket->nik_request)->first();
            $namaEmployee = $ticketEmployee ? $ticketEmployee->nama : 'Bapak/Ibu';
            $link = route('other-facilities.detail', ['id_tiket' => $id_tiket]);
            $statusTiket = $request->status;

            $target = $ticket->whatsapp;


            if ($statusTiket === 'Closed') {
                $message = "Halo " . $namaEmployee . "!\n\nTicketing dengan ID #" . $id_tiket . " dan status " . $statusTiket . " sudah berhasil diupdate dan ditutup.\n\nTerima kasih telah menggunakan layanan kami. Jangan lupa untuk selalu cek Employee Information Portal (EIP) untuk informasi selanjutnya. Jika Anda memiliki pertanyaan lebih lanjut atau membutuhkan bantuan, jangan ragu untuk menghubungi tim General Affairs kami.\n\nTerima kasih!\n\nInfo lebih lanjut tentang tiket ini: \n" . $link;
            } else {
                $message = "Halo " . $namaEmployee . "!\n\nTicketing dengan ID #" . $id_tiket . " dan status " . $statusTiket . " sudah berhasil diupdate.\n\nTerima kasih telah menggunakan layanan kami. Jangan lupa untuk selalu cek Employee Information Portal (EIP) untuk informasi selanjutnya. Jika Anda memiliki pertanyaan lebih lanjut atau membutuhkan bantuan, jangan ragu untuk menghubungi tim General Affairs kami.\n\nTerima kasih!\n\nInfo lebih lanjut tentang tiket ini: \n" . $link;
            }

            SendWhatsAppMessageJob::dispatch($target, $message)->onQueue('whatsapp');
            Alert::success('Success', 'Update Successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Error', 'Error occurred during update');
            return redirect()->back();
        }
    }

    public function delete($id_tiket)
    {
        try {
            $ticket = Other::find($id_tiket);

            if (!$ticket) {
                Alert::error('Error', 'Ticket not found');
                return redirect()->back();
            }

            $fileName = $ticket->file;

            if (Storage::exists('public/gaOther/' . $fileName)) {
                Storage::delete('public/gaOther/' . $fileName);
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
                $uuid = str_pad(mt_rand(0, 999), 3, '0', STR_PAD_LEFT);
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
