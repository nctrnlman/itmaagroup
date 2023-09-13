<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Comment;
use App\Models\Employee;
use App\Models\Ticketing;
use App\Models\AccessMenu;
use Illuminate\Support\Str;
use App\Models\GAFacilities;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\SendWhatsAppMessageJob;
use RealRashid\SweetAlert\Facades\Alert;

class GAFacilitiesController extends Controller
{
    public function index()
    {
        $userId = session('user')->idnik;
        $accessType = session('user')->access_type;

        $usersGA = AccessMenu::join('user', 'access_menu.idnik', '=', 'user.idnik')
            ->whereIn('access_menu.access_type', ['GA Building', 'admin', 'GA RP', 'GA ATK'])
            ->get();

        $isAdmin = AccessMenu::where('idnik', $userId)
            ->whereIn('access_type', ['admin'])
            ->exists();


        $allUsers = Employee::all();

        if ($isAdmin) {
            $tickets = GAFacilities::join('user', 'ga_facilities.id_nik_request', '=', 'user.idnik')
                ->select('ga_facilities.*', 'user.*')
                ->orderByRaw("FIELD(status_tiket, 'Pending', 'Process', 'Closed', 'Rejected')")
                ->orderBy('start_date', 'desc')
                ->get();

            $totalTickets = $tickets->count();
            $pendingTickets = $tickets->where('status_tiket', 'Pending')->count();
            $processTickets = $tickets->where('status_tiket', 'Process')->count();
            $closedTickets = $tickets->where('status_tiket', 'Closed')->count();
        } elseif ($accessType === 'GA ATK') {
            $tickets = GAFacilities::join('user', 'ga_facilities.id_nik_request', '=', 'user.idnik')
                ->select('ga_facilities.*', 'user.*')
                ->where(function ($query) use ($userId) {
                    $query->where('kategori_tiket', 'ATK/Stationary')
                        ->orWhere('id_nik_request', $userId);
                })
                ->orderByRaw("FIELD(status_tiket, 'Pending', 'Process', 'Closed', 'Rejected')")
                ->orderBy('start_date', 'desc')
                ->get();

            $totalTickets = $tickets->count();
            $pendingTickets = $tickets->where('status_tiket', 'Pending')->count();
            $processTickets = $tickets->where('status_tiket', 'Process')->count();
            $closedTickets = $tickets->where('status_tiket', 'Closed')->count();
        } elseif ($accessType === 'GA Building') {
            $tickets = GAFacilities::join('user', 'ga_facilities.id_nik_request', '=', 'user.idnik')
                ->select('ga_facilities.*', 'user.*')
                ->where(function ($query) use ($userId) {
                    $query->where('kategori_tiket', 'Building Maintenance support')
                        ->orWhere('id_nik_request', $userId);
                })
                ->orderByRaw("FIELD(status_tiket, 'Pending', 'Process', 'Closed', 'Rejected')")
                ->orderBy('start_date', 'desc')
                ->get();

            $totalTickets = $tickets->count();
            $pendingTickets = $tickets->where('status_tiket', 'Pending')->count();
            $processTickets = $tickets->where('status_tiket', 'Process')->count();
            $closedTickets = $tickets->where('status_tiket', 'Closed')->count();
        } elseif ($accessType === 'GA RP') {
            $tickets = GAFacilities::join('user', 'ga_facilities.id_nik_request', '=', 'user.idnik')
                ->select('ga_facilities.*', 'user.*')
                ->where(function ($query) use ($userId) {
                    $query->where('kategori_tiket', 'Other facilities Request (Purchase Request)')
                        ->orWhere('id_nik_request', $userId);
                })
                ->orderByRaw("FIELD(status_tiket, 'Pending', 'Process', 'Closed', 'Rejected')")
                ->orderBy('start_date', 'desc')
                ->get();

            $totalTickets = $tickets->count();
            $pendingTickets = $tickets->where('status_tiket', 'Pending')->count();
            $processTickets = $tickets->where('status_tiket', 'Process')->count();
            $closedTickets = $tickets->where('status_tiket', 'Closed')->count();
        } else {
            $tickets = GAFacilities::where('id_nik_request', $userId)
                ->orderByRaw("FIELD(status_tiket, 'Pending', 'Process', 'Closed', 'Rejected')")
                ->orderBy('start_date', 'desc')
                ->get();
            $totalTickets = $tickets->count();
            $pendingTickets = $tickets->where('status_tiket', 'Pending')->count();
            $processTickets = $tickets->where('status_tiket', 'Process')->count();
            $closedTickets = $tickets->where('status_tiket', 'Closed')->count();
        }



        return view('facilities.ga-facilities', [
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
                'kategori_tiket' => 'required',    'request' => 'required',
            ]);

            $id_nik_request = $request->input('request');

            $generatedId = false;
            $idGA = '';

            while (!$generatedId) {
                $currentDate = Carbon::now();
                $year = substr($currentDate->year, -2);
                $idnik =  $id_nik_request;
                $uuid = str_pad(mt_rand(0, 999), 3, '0', STR_PAD_LEFT);
                $idGA = 'GA' . $year . $currentDate->format('md') . substr($idnik, -3) . $uuid;

                $existingTask = GAFacilities::where('id_ga_facilities', $idGA)->first();

                if (!$existingTask) {
                    $generatedId = true;
                }
            }


            $filename1 = null;
            if ($request->hasFile('lampiran1')) {
                $lampiran1 = $request->file('lampiran1');
                $filename1 = $idGA . '_' . $lampiran1->getClientOriginalName();
                $lampiran1->storeAs('public/gafacilities', $filename1);
            }

            $GAFacilities = new GAFacilities();
            $GAFacilities->id_ga_facilities = $idGA;
            $GAFacilities->id_nik_request =  $id_nik_request;
            $GAFacilities->start_date = $currentDate;
            $GAFacilities->disc_keluhan = $request->desc;
            $GAFacilities->kategori_tiket = $request->kategori_tiket;
            $GAFacilities->lampiran1 = $filename1;
            $GAFacilities->whatsapp = $request->wa;

            $GAFacilities->save();

            $employee = Employee::where('idnik', $id_nik_request)->first();
            $namaEmployee = $employee ? $employee->nama : 'Bapak/Ibu';
            $link = route('ga-facilities.detail', ['id_tiket' => $idGA]);

            $target = $request->wa;
            $message = "Halo " . $namaEmployee . ",\n\nTiket dengan ID #" . $idGA . " Anda telah berhasil dibuat dengan status 'OPEN'.\n\nThank you for your time to fill and support EIP (Employee Information Portal) for request System, We will respond to your request, please wait we will process according to the queue !! :) \n
Terima kasih atas waktunya untuk mengisi dan mendukung sistem request EIP, kami akan memproses permintaan anda, mohon kesediaannya untuk menunggu sesuai dengan antrian !! \n
Jika Anda memiliki pertanyaan lebih lanjut atau membutuhkan bantuan, jangan ragu untuk menghubungi tim General Affairs kami: " . $link . "\n\nTerima kasih! :)";
            SendWhatsAppMessageJob::dispatch($target, $message)->onQueue('whatsapp');




            Alert::success('Success', 'Ticket created successfully!');
            return redirect()->back();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->getMessageBag();

            if ($errors->has('kategori_tiket')) {
                Alert::error('Error', 'Please insert Service Type.');
                return redirect()->back();
            } elseif ($errors->has('desc')) {
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
        $ticket = GAFacilities::join('user', 'ga_facilities.id_nik_request', '=', 'user.idnik')
            ->join('login', 'login.idnik', '=', 'ga_facilities.id_nik_request')
            ->select('ga_facilities.*', 'login.*', 'user.*')
            ->where('ga_facilities.id_ga_facilities', $id_tiket)
            ->first();

        if ($ticket) {
            if ($ticket->kategori_tiket === 'Building Maintenance support') {
                $usersGA = AccessMenu::join('user', 'access_menu.idnik', '=', 'user.idnik')
                    ->whereIn('access_menu.access_type', ['GA Building'])
                    ->get();
            } elseif ($ticket->kategori_tiket === 'Other facilities Request (Purchase Request)') {
                $usersGA = AccessMenu::join('user', 'access_menu.idnik', '=', 'user.idnik')
                    ->whereIn('access_menu.access_type', ['GA RP'])
                    ->get();
            } elseif ($ticket->kategori_tiket === 'ATK/Stationary') {
                $usersGA = AccessMenu::join('user', 'access_menu.idnik', '=', 'user.idnik')
                    ->whereIn('access_menu.access_type', ['GA ATK'])
                    ->get();
            } else {
                // Default value jika kategori_tiket tidak sesuai dengan yang diharapkan
                $usersGA = collect(); // Atau $usersGA = [];
            }
        } else {
            // Jika data dengan ID tidak ditemukan, berikan nilai default untuk $usersGA
            $usersGA = collect(); // Atau $usersGA = [];
        }

        $comments = Comment::join('user', 'komentar.nik_komen', '=', 'user.idnik')
            ->where('komentar.id_tiket', $id_tiket)
            ->select('komentar.*', 'user.*')
            ->orderBy('komentar.datetime', 'asc')
            ->get();

        return view('facilities.ga-facilities-detail', ['ticket' => $ticket, 'usersGA' => $usersGA, 'comments' => $comments]);
    }

    public function update(Request $request, $id_tiket)
    {
        try {
            $validatedData = $request->validate([
                'justification' => 'required',
                'actionNote' => 'required',
            ]);

            $ticket = GAFacilities::find($id_tiket);

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
            $ticket->nik_pic = $request->input('nik_pic');
            $ticket->save();

            $ticketEmployee = Employee::where('idnik', $ticket->id_nik_request)->first();
            $namaEmployee = $ticketEmployee ? $ticketEmployee->nama : 'Bapak/Ibu';
            $link = route('ga-facilities.detail', ['id_tiket' => $id_tiket]);
            $statusTiket = $request->status_tiket;

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

    public function delete(Request $request, $id_tiket)
    {
        try {
            $ticket = GAFacilities::find($id_tiket);

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
