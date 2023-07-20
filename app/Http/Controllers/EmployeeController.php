<?php

namespace App\Http\Controllers;



use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

// use App\Http\Controllers\Controller;


class EmployeeController extends Controller
{

    public function getEmployee()
    {
        $employees = Employee::join('login', 'user.idnik', '=', 'login.idnik')
            ->select('login.*', 'user.*')
            ->get();
        // dd($employees);
        return view('employees', ['employees' => $employees]);
    }

    public function insert(Request $request)
    {
        $request->validate([
            'idnik' => 'required',
            'nama' => 'required',
            'divisi' => 'required ',
            'position' => 'required',
            'lokasi' => 'required',
        ]);

        $data = $request->only(['idnik', 'nama', 'divisi', 'position', 'lokasi']);
        Employee::create($data);

        return redirect()->back()->with('success', 'Employee added successfully!');
    }

    public function getUpdateEmployee($idnik)
    {

        $employee = Employee::join('login', 'user.idnik', '=', 'login.idnik')
            ->select('login.*', 'user.*')
            ->where('user.idnik', $idnik) // Menggunakan nilai $idnik yang diinginkan
            ->first();


        // dd($employee);

        return view('edit-profile', ['employee' => $employee]);
    }

    public function insertUpdateEmployee(Request $request, $idnik)
    {
        $employee = Employee::join('login', 'user.idnik', '=', 'login.idnik')
            ->select('login.*', 'user.*')
            ->where('user.idnik', $idnik) // Menggunakan nilai $idnik yang diinginkan
            ->first();

        if (!$employee) {
            return redirect()->back()->with('error', 'Data employee tidak ditemukan.');
        }

        $employee->nama = $request->input('nama');
        $employee->company = $request->input('company');
        $employee->lokasi = $request->input('lokasi');
        $employee->divisi = $request->input('divisi');
        $employee->departement = $request->input('department');
        $employee->section = $request->input('section');
        $employee->position = $request->input('position');
        $employee->clasifikasi = $request->input('clasifikasi');
        $employee->atasan = $request->input('atasan');
        $employee->roster = $request->input('roster');
        $employee->poh = $request->input('poh');
        $employee->doh = $request->input('doh');
        $employee->status = $request->input('status');
        // Lanjutkan dengan mengupdate kolom-kolom lainnya sesuai kebutuhan
        // dd($employee);
        $employee->save();

        return redirect()->route('employees', ['idnik' => $idnik])->with('success', 'Data employee berhasil diupdate.');
    }

    public function changePassword(Request $request, $idnik)
    {
        $employee = User::join('user', 'login.idnik', '=', 'user.idnik')
            ->select('login.*', 'user.*')
            ->where('user.idnik', $idnik) // Menggunakan nilai $idnik yang diinginkan
            ->first();


        if (!$employee) {
            return redirect()->back()->with('error', 'Data employee tidak ditemukan.');
        }

        $employee->fill($request->only(['role'])); // Hanya mengupdate kolom 'role'
        $password = $request->input('password');
        if ($password) {
            $hashedPassword = Hash::make($password);
            $employee->password = $hashedPassword; // Hanya mengupdate kolom 'password' jika ada input password baru
        }

        $employee->save();

        return redirect()->route('employees', ['idnik' => $idnik])->with('success', 'Data employee berhasil diupdate.');
    }


    public function photoProfile(Request $request, $idnik)
    {
        $employee = Employee::join('login', 'user.idnik', '=', 'login.idnik')
            ->select('login.*', 'user.*')
            ->where('user.idnik', $idnik) // Menggunakan nilai $idnik yang diinginkan
            ->first();


        if (!$employee) {
            return redirect()->back()->with('error', 'Data employee tidak ditemukan.');
        }

        if ($request->hasFile('file_foto')) {
            $file = $request->file('file_foto');
            $filename = $idnik . '.' . $file->getClientOriginalExtension();

            // Simpan file foto ke penyimpanan yang telah dikonfigurasi
            $file->storeAs('uploads', $filename, 'uploads');

            // Update kolom 'photo' pada model 'Employee'
            $employee->file_foto = $filename;
            // dd($employee);
            $employee->save();

            return redirect()->back()->with('success', 'Foto berhasil diunggah.');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah foto.');
    }

    public function viewProfile($idnik)
    {
        $employee = Employee::join('login', 'user.idnik', '=', 'login.idnik')
            ->select('login.*', 'user.*')
            ->where('user.idnik', $idnik) // Menggunakan nilai $idnik yang diinginkan
            ->first();


        // dd($employee);

        return view('view-employee', ['employee' => $employee]);
    }
}
