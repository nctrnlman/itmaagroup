<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
{
    $totalEmployee = Employee::count();
    $employeeHO = Employee::where('company', 'like', '%HO%')->count();
    $employeeBCPM = Employee::where('company', 'like', '%BCPM%')->count();
    $employeeOBI = Employee::where('company', 'like', '%OBI%')->count();

    // dd($employeeHO);

    return view('index', compact('totalEmployee', 'employeeHO', 'employeeBCPM', 'employeeOBI'));
}
}
