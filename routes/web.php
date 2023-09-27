<?php

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Models\Facilities\Stationary;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ITHelpdeskController;
use App\Http\Controllers\Tasks\TaskController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\GAFacilitiesController;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\Facilities\AtkController;
use App\Http\Controllers\CompanyRegulationController;
use App\Http\Controllers\Facilities\BuildingController;
use App\Http\Controllers\Facilities\StationaryController;
use App\Http\Controllers\Facilities\OtherFacilitiesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

// Testing
// Route::get('/{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');


//login router
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('loginForm');
Route::post('/login', [LoginController::class, 'login'])->name('login');

//Company Regulation Router
Route::get('/company-regulation', [CompanyRegulationController::class, 'index'])->name('company-regulation');
Route::get('/download',  [CompanyRegulationController::class, 'downloadFile'])->name('file.download');


// Rute-rute yang perlu dilindungi oleh middleware auth
Route::group(['middleware' => 'auth'], function () {
    //it helpdesk
    Route::get('/it-helpdesk', [ITHelpdeskController::class, 'index'])->name('it-helpdesk');
    Route::post('/it-helpdesk', [ITHelpdeskController::class, 'insert'])->name('it-helpdesk.insert');
    Route::get('/it-helpdesk/detail/{id_tiket}', [ITHelpdeskController::class, 'detailTicket'])->name('it-helpdesk.detail');
    Route::post('/it-helpdesk/update/{id_tiket}', [ITHelpdeskController::class, 'update'])->name('it-helpdesk.update');
    Route::delete('/it-helpdesk/delete/{id_tiket}', [ITHelpdeskController::class, 'delete'])->name('it-helpdesk.delete');
    Route::post('/it-helpdesk/komentar', [ITHelpdeskController::class, 'komentar'])->name('it-helpdesk.komentar');

    //project
    Route::get('/project', [ProjectController::class, 'index'])->name('projects.index');
    Route::post('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::get('/project-list', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('/projects/{id}', [ProjectController::class, 'view'])->name('projects.view');
    Route::get('/projects/{id}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::post('/projects/{id}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{id}', [ProjectController::class, 'delete'])->name('projects.delete');

    //Task Route
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [TaskController::class, 'createForm'])->name('tasks.createForm');
    Route::post('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::get('/tasks/view/{id_task}', [TaskController::class, 'view'])->name('tasks.view');
    Route::get('/tasks/edit/{id_task}', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::post('/tasks/{id_task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/delete/{id_task}', [TaskController::class, 'delete'])->name('tasks.delete');

    //Employee Router
    Route::post('/employees', [EmployeeController::class, 'insert'])->name('employees.insert');
    Route::get('/employees', [EmployeeController::class, 'getEmployee'])->name('employees');
    Route::get('/employee/view/{idnik}', [EmployeeController::class, 'viewProfile'])->name('employee.view');
    Route::get('/employee/update/{idnik}', [EmployeeController::class, 'getUpdateEmployee'])->name('employee.getId');
    Route::post('/employee/update/{idnik}', [EmployeeController::class, 'insertUpdateEmployee'])->name('employee.update');
    Route::post('/employee/update/change-password/{idnik}', [EmployeeController::class, 'changePassword'])->name('changePassword');
    Route::post('/employee/update/photo-profile/{idnik}', [EmployeeController::class, 'photoProfile'])->name('employee.photoProfile');

    //administrator
    Route::get('/admin/dashboard', [AdministratorController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin', [AdministratorController::class, 'store'])->name('admin.store');
    Route::put('/admin/{id}', [AdministratorController::class, 'update'])->name('admin.update');
    Route::delete('/admin/{id}', [AdministratorController::class, 'destroy'])->name('admin.destroy');

    //ATK
    Route::get('/atk/dashboard', [AtkController::class, 'index'])->name('atk.index');
    Route::post('/atk', [AtkController::class, 'store'])->name('atk.store');
    Route::put('/atk/{id}', [AtkController::class, 'update'])->name('atk.update');
    Route::delete('/atk/{id}', [AtkController::class, 'destroy'])->name('atk.destroy');

    //download
    Route::get('/download/{folder}/{filename}', [DownloadController::class, 'download'])->name('download');

    //GA Other Facilities
    Route::get('/other-facilities', [OtherFacilitiesController::class, 'index'])->name('other-facilities.index');
    Route::post('/other-facilities/insert', [OtherFacilitiesController::class, 'insert'])->name('other-facilities.insert');
    Route::get('/other-facilities/detail/{id_tiket}', [OtherFacilitiesController::class, 'detailTicket'])->name('other-facilities.detail');
    Route::post('/other-facilities/komentar', [OtherFacilitiesController::class, 'komentar'])->name('other-facilities.komentar');
    Route::put('/other-facilities/update/{id_tiket}', [OtherFacilitiesController::class, 'update'])->name('other-facilities.update');
    Route::delete('/other-facilities/delete/{id_tiket}', [OtherFacilitiesController::class, 'delete'])->name('other-facilities.delete');


    //GA Building Facilities
    Route::get('/building-facilities', [BuildingController::class, 'index'])->name('building-facilities.index');
    Route::post('/building-facilities/insert', [BuildingController::class, 'insert'])->name('building-facilities.insert');
    Route::get('/building-facilities/detail/{id_tiket}', [BuildingController::class, 'detailTicket'])->name('building-facilities.detail');
    Route::post('/building-facilities/komentar', [BuildingController::class, 'komentar'])->name('building-facilities.komentar');
    Route::put('/building-facilities/update/{id_tiket}', [BuildingController::class, 'update'])->name('building-facilities.update');
    Route::delete('/building-facilities/delete/{id_tiket}', [BuildingController::class, 'delete'])->name('building-facilities.delete');

    //GA Stationary Facilities
    Route::get('/stationary-facilities', [StationaryController::class, 'index'])->name('stationary-facilities.index');
    Route::post('/stationary-facilities/insert', [StationaryController::class, 'insert'])->name('stationary-facilities.insert');
    Route::get('/stationary-facilities/detail/{id_tiket}', [StationaryController::class, 'detailTicket'])->name('stationary-facilities.detail');
    Route::post('/stationary-facilities/komentar', [StationaryController::class, 'komentar'])->name('stationary-facilities.komentar');
    Route::put('/stationary-facilities/update/{id_tiket}', [StationaryController::class, 'update'])->name('stationary-facilities.update');
    Route::put('/stationary-detail/update/{id_tiket}', [StationaryController::class, 'updateRequest'])->name('stationary-detail.update');
    Route::delete('/stationary-facilities/delete/{id_tiket}', [StationaryController::class, 'delete'])->name('stationary-facilities.delete');
});


Route::fallback(function () {
    return view('auth-404-basic');
});
