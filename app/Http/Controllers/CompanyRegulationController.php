<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyRegulationController extends Controller
{
    public function index()
    {
        return view('company-regulation');
    }
    public function downloadFile()
    {
    $filePath = storage_path('app/public/documents/PP%20PT.%20MAA%202021-2023%20+%20Daftar%20isi.pdf'); // Tentukan path file yang akan diunduh

    return response()->download($filePath);
    }
}
