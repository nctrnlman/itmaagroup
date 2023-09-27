<?php

namespace App\Http\Controllers\Facilities;

use Carbon\Carbon;
use App\Models\Comment;
use App\Models\Employee;
use App\Models\AccessMenu;
use Illuminate\Http\Request;
use App\Models\Facilities\Atk;
use App\Http\Controllers\Controller;
use App\Jobs\SendWhatsAppMessageJob;
use App\Models\Facilities\Stationary;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Facilities\StationaryDetail;

class StationaryController extends Controller
{
    public function index()
    {
        $userId = session('user')->idnik;
        $accessType = session('user')->access_type;
        $atkList = Atk::all();

        $usersGA = AccessMenu::join('user', 'access_menu.idnik', '=', 'user.idnik')
            ->whereIn('access_menu.access_type', ['GA Stationary', 'admin'])
            ->get();

        $isAdmin = AccessMenu::where('idnik', $userId)
            ->whereIn('access_type', ['admin'])
            ->exists();


        $allUsers = Employee::all();

        if ($isAdmin || $accessType === 'GA Stationary') {
            $tickets = Stationary::join('user', 'ga_stationary.nik_request', '=', 'user.idnik')
                ->select('ga_stationary.*', 'user.*')
                ->orderByRaw("FIELD(status, 'Pending', 'Process', 'Closed', 'Rejected')")
                ->orderBy('start_date', 'desc')
                ->get();

            $totalTickets = $tickets->count();
            $pendingTickets = $tickets->where('status', 'Pending')->count();
            $processTickets = $tickets->where('status', 'Process')->count();
            $closedTickets = $tickets->where('status', 'Closed')->count();
        } else {
            $tickets = Stationary::where('nik_request', $userId)
                ->orderByRaw("FIELD(status, 'Pending', 'Process', 'Closed', 'Rejected')")
                ->orderBy('start_date', 'desc')
                ->get();
            $totalTickets = $tickets->count();
            $pendingTickets = $tickets->where('status', 'Pending')->count();
            $processTickets = $tickets->where('status', 'Process')->count();
            $closedTickets = $tickets->where('status', 'Closed')->count();
        }



        return view('facilities.stationary-facilities', [
            'tickets' => $tickets, 'totalTickets' => $totalTickets,
            'pendingTickets' => $pendingTickets,
            'processTickets' => $processTickets,
            'closedTickets' => $closedTickets,
            'usersGA' => $usersGA,
            'atkList' => $atkList,
            'allUsers' => $allUsers
        ]);
    }

    public function insert(Request $request)
    {
        try {
            $request->validate([
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

                $idGA = 'ATK' . $year . $currentDate->format('md') . substr($idnik, -3) . $uuid;

                $existingTask = Stationary::where('id_ga_stationary', $idGA)->first();

                if (!$existingTask) {
                    $generatedId = true;
                }
            }


            $Stationary = new Stationary();
            $Stationary->id_ga_stationary = $idGA;
            $Stationary->nik_request =  $nik_request;
            $Stationary->start_date = $currentDate;
            $Stationary->category = 'ATK/Stationary';
            $Stationary->status = 'Pending';
            $Stationary->whatsapp = $request->wa;
            $Stationary->save();

            for ($i = 1; $i <= 5; $i++) {
                $atkKey = 'atk' . $i;
                $qtyKey = 'qty' . $i;

                if ($request->has($atkKey) && $request->has($qtyKey)) {
                    $idAtk = $request->input($atkKey);
                    $qty = $request->input($qtyKey);

                    if ($idAtk) {
                        $uuid = str_pad(mt_rand(0, 999), 3, '0', STR_PAD_LEFT);

                        $detailIdGA = 'ARD' . $year . $currentDate->format('md') . substr($idnik, -3) . $uuid;

                        // Simpan data ke tabel stationary_request_detail
                        $stationaryRequestDetail = new StationaryDetail();
                        $stationaryRequestDetail->id_request_detail = $detailIdGA;
                        $stationaryRequestDetail->id_ga_stationary = $idGA;
                        $stationaryRequestDetail->id_atk = $idAtk;
                        $stationaryRequestDetail->total_request = $qty;
                        $stationaryRequestDetail->total_approve = 0;
                        $stationaryRequestDetail->feedback = '';
                        $stationaryRequestDetail->save();
                    }
                }
            }

            if ($request->has('atk6') && $request->has('qty6')) {
                $idAtk6 = $request->input('atk6');
                $qty6 = $request->input('qty6');

                if ($idAtk6 && $qty6) {
                    $uuid = str_pad(mt_rand(0, 999), 3, '0', STR_PAD_LEFT);

                    $detailIdGA6 = 'ARD' . $year . $currentDate->format('md') . substr($idnik, -3) . $uuid;

                    // Simpan data ke tabel stationary_request_detail untuk qty6 dan atk6
                    $stationaryRequestDetail6 = new StationaryDetail();
                    $stationaryRequestDetail6->id_request_detail = $detailIdGA6;
                    $stationaryRequestDetail6->id_ga_stationary = $idGA;
                    $stationaryRequestDetail6->id_atk = $idAtk6;
                    $stationaryRequestDetail6->total_request = $qty6;
                    $stationaryRequestDetail6->total_approve = 0;
                    $stationaryRequestDetail6->feedback = '';
                    $stationaryRequestDetail6->save();
                }
            }


            $employee = Employee::where('idnik', $nik_request)->first();


            $namaEmployee = $employee ? $employee->nama : 'Bapak/Ibu';

            $link = route('stationary-facilities.detail', ['id_tiket' => $idGA]);

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
        $ticket = Stationary::join('user', 'ga_stationary.nik_request', '=', 'user.idnik')
            ->join('login', 'login.idnik', '=', 'ga_stationary.nik_request')
            ->leftJoin('stationary_request_detail', 'stationary_request_detail.id_ga_stationary', '=', 'ga_stationary.id_ga_stationary')
            ->leftJoin('atk', 'stationary_request_detail.id_atk', '=', 'atk.id_atk')
            ->select('ga_stationary.*', 'login.*', 'user.*', 'stationary_request_detail.*', 'atk.*')
            ->where('ga_stationary.id_ga_stationary', $id_tiket)
            ->first();




        if ($ticket && $ticket->category === 'ATK/Stationary') {
            $usersGA = AccessMenu::join('user', 'access_menu.idnik', '=', 'user.idnik')
                ->whereIn('access_menu.access_type', ['GA Stationary'])
                ->get();
        } else {
            $usersGA = collect();
        }

        $comments = Comment::join('user', 'komentar.nik_komen', '=', 'user.idnik')
            ->where('komentar.id_tiket', $id_tiket)
            ->select('komentar.*', 'user.*')
            ->orderBy('komentar.datetime', 'asc')
            ->get();

        $requestDetails = StationaryDetail::leftJoin('atk', 'stationary_request_detail.id_atk', '=', 'atk.id_atk')
            ->select('stationary_request_detail.*', 'atk.description', 'atk.id_atk AS atk_id')
            ->where('stationary_request_detail.id_ga_stationary', $id_tiket)
            ->get();



        return view('facilities.stationary-facilities-detail', [
            'ticket' => $ticket,
            'usersGA' => $usersGA,
            'comments' => $comments,
            'requestDetails' => $requestDetails,
        ]);
    }

    public function update(Request $request, $id_tiket)
    {
        try {
            $ticket = Stationary::find($id_tiket);


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
            $link = route('stationary-facilities.detail', ['id_tiket' => $id_tiket]);
            $statusTiket = $request->status;

            $target = $ticket->whatsapp;


            if ($statusTiket === 'Closed') {
                $message = "Halo " . $namaEmployee . "!\n\nTicketing dengan ID #" . $id_tiket . " dan status " . $statusTiket . " sudah berhasil diupdate dan ditutup.\n\nTerima kasih telah menggunakan layanan kami. Jangan lupa untuk selalu cek Employee Information Portal (EIP) untuk informasi selanjutnya_stationary. Jika Anda memiliki pertanyaan lebih lanjut atau membutuhkan bantuan, jangan ragu untuk menghubungi tim General Affairs kami.\n\nTerima kasih!\n\nInfo lebih lanjut tentang tiket ini: \n" . $link;
            } else {
                $message = "Halo " . $namaEmployee . "!\n\nTicketing dengan ID #" . $id_tiket . " dan status " . $statusTiket . " sudah berhasil diupdate.\n\nTerima kasih telah menggunakan layanan kami. Jangan lupa untuk selalu cek Employee Information Portal (EIP) untuk informasi selanjutnya_stationary. Jika Anda memiliki pertanyaan lebih lanjut atau membutuhkan bantuan, jangan ragu untuk menghubungi tim General Affairs kami.\n\nTerima kasih!\n\nInfo lebih lanjut tentang tiket ini: \n" . $link;
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
            $ticket = Stationary::find($id_tiket);

            if (!$ticket) {
                Alert::error('Error', 'Ticket not found');
                return redirect()->back();
            }

            $fileName = $ticket->file;

            if (Storage::exists('public/gaStationary/' . $fileName)) {
                Storage::delete('public/gaStationary/' . $fileName);
            }

            $ticket->delete();

            Alert::success('Success', 'Ticket deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Error', 'Error occurred during ticket deletion');
            return redirect()->back();
        }
    }

    public function updateRequest(Request $request, $id_tiket)
    {
        $validatedData = $request->validate([
            'total_approve' => 'required|numeric',
            'feedback' => 'nullable|string',
        ]);

        try {
            $requestDetail = StationaryDetail::findOrFail($id_tiket);

            $requestDetail->total_approve = $validatedData['total_approve'];
            $requestDetail->feedback = $validatedData['feedback'];

            $requestDetail->save();
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
