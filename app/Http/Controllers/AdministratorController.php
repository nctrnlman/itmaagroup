<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Employee;
use App\Models\AccessMenu;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class AdministratorController extends Controller
{
    public function dashboard()
    {
        $admins = AccessMenu::join('user', 'access_menu.idnik', '=', 'user.idnik')
        ->select('access_menu.*', 'user.*')
        ->get();

        $users = Employee::leftJoin('access_menu', 'user.idnik', '=', 'access_menu.idnik')
    ->select('user.*')
    ->whereNull('access_menu.id_access') // Pilih hanya karyawan yang belum memiliki akses (tidak ada id di AccessMenu)
    ->get();

    return view('administrator.index', compact('admins','users'));
    }

     public function store(Request $request)
     {
        try {
            $request->validate([
                'idnik' => 'required',
                'access_type' => 'required',
            ]);

         $generatedId = false;
            $idAccess = '';

            while (!$generatedId) {
                $currentDate = Carbon::now();
                $year = substr($currentDate->year, -2);
                $idnik =  $request->idnik;
                $generatedUuid = Str::uuid();
                $parts = explode("-", $generatedUuid);
                $numericUuid = implode("", array_filter($parts, 'is_numeric'));
                $uuid = substr($numericUuid, 0, 3);
                $idAccess = 'ACS' . $year . $currentDate->format('md') . substr($idnik, -3) . $uuid;

                $existingTask = AccessMenu::where('id_access', $idAccess)->first();

                if (!$existingTask) {

                    $generatedId = true;
                }
            }
            $admin = new AccessMenu();
            $admin->id_access = $idAccess;
            $admin->idnik = $idnik;
            $admin->access_type = $request->access_type;
            $admin->save();

            Session::flash('success', 'Administrator assigned successfully!');
        } catch (\Exception $e) {
            Session::flash('error', 'Failed to assign administrator.');
        }

        return redirect()->back();
     }
 
     public function update(Request $request, $id)
     {
        try {
            $request->validate([
                'access_type' => 'required',
            ]);

            $admin = AccessMenu::findOrFail($id);
            $admin->access_type = $request->access_type;
            $admin->save();

            Session::flash('success', 'Administrator updated successfully!');
        } catch (\Exception $e) {
            Session::flash('error', 'Failed to update administrator.');
        }

        return redirect()->back();
     }
 
     public function destroy($id)
     {
        try {
            $admin = AccessMenu::findOrFail($id);
            $admin->delete();

            Session::flash('success', 'Administrator deleted successfully!');
        } catch (\Exception $e) {
            Session::flash('error', 'Failed to delete administrator.');
        }

        return redirect()->back();

     }
}
