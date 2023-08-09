<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SuperadminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('homepage');




Route::get('/admin/register', [AdminController::class, 'showRegistrationForm'])->name('admin.register');
Route::post('/admin/register', [AdminController::class, 'register'])->name('admin.register.submit');




Route::get('/employee/register', [EmployeeController::class, 'showRegistrationForm'])->name('employee.register');
Route::post('/employee/register', [EmployeeController::class, 'register'])->name('employee.register.submit');


Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.post');
Route::post('/admin/verify-otp', [AdminController::class, 'verifyOtp'])->name('admin.verify-otp');
Route::get('admin/dashboard/{name}', [AdminController::class, 'dashboard'])->name('admin.dashboard');



Route::get('/employee/login', [EmployeeController::class, 'showLoginForm'])->name('employee.login');
Route::post('/employee/login',  [EmployeeController::class, 'login'])->name('employee.login.post');
Route::post('/employee/verify-otp',  [EmployeeController::class, 'verifyOtp'])->name('employee.verify-otp');
Route::get('employee/dashboard/{name}', [EmployeeController::class, 'dashboard'])->name('employee.dashboard');
Route::post('/employee/upload-file', [EmployeeController::class, 'uploadFile'])->name('employee.upload-file');
Route::delete('/employee/files/{id}', [EmployeeController::class, 'deleteFile'])->name('employee.delete-file');
Route::get('/employee/view-file/{id}', [EmployeeController::class, 'viewFile'])->name('employee.view-file');
Route::get('/employee/download-file/{id}', [EmployeeController::class, 'downloadFile'])->name('employee.download-file');

// Admin routes

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::post('/admin/verify-file/{id}', [AdminController::class, 'verifyFile'])->name('admin.verify-file');
Route::delete('/admin/files/{id}', [AdminController::class, 'deleteFile'])->name('admin.delete-file');
Route::get('/admin/verified-files', [AdminController::class, 'verifiedFiles'])->name('admin.verified-files');
Route::get('/admin/view-file/{id}', [AdminController::class, 'viewFile'])->name('admin.view-file');
Route::get('/admin/employee-approval', [AdminController::class, 'employeeApproval'])->name('admin.employee-approval');
Route::post('/admin/approve-employee/{id}', [AdminController::class, 'approveEmployee'])->name('admin.approve-employee');
Route::post('/admin/reject-employee/{id}', [AdminController::class, 'rejectEmployee'])->name('admin.reject-employee');


// user homepage

Route::get('/user', [UserController::class, 'index'])->name('user.home');
Route::get('/user/view/{filename}', [UserController::class, 'viewFile'])->name('user.view');
Route::post('/user/search', [UserController::class, 'search'])->name('user.search');

// Super Admin routes

Route::group(['prefix' => 'superadmin'], function () {
    Route::get('/', [SuperadminController::class, 'index'])->name('superadmin.index');
    Route::get('/admin/{admin}', [SuperadminController::class, 'viewAdmin'])->name('superadmin.viewAdmin');
    Route::get('/employee/{employee}', [SuperadminController::class, 'viewEmployee'])->name('superadmin.viewEmployee');
    // Route::delete('/admin/{admin}', [SuperadminController::class, 'deleteAdmin'])->name('superadmin.deleteAdmin');
    Route::delete('/delete-admin/{admin}', [SuperadminController::class, 'deleteAdmin'])->name('superadmin.deleteAdmin');
    Route::delete('/employee/{employee}', [SuperadminController::class, 'deleteEmployee'])->name('superadmin.deleteEmployee');
    // Add more routes for other Superadmin actions
    Route::delete('/file/{file}', [SuperadminController::class, 'deleteFile'])->name('superadmin.deleteFile');
    Route::get('/file/{file}/status', [SuperadminController::class, 'changeFileStatus'])->name('superadmin.changeFileStatus');
    Route::put('/file/{file}/status', [SuperadminController::class, 'updateFileStatus'])->name('superadmin.updateFileStatus');
    Route::get('/edit-feedback/{file}', [SuperadminController::class, 'editFeedback'])->name('superadmin.editFeedback');
    Route::put('/update-feedback/{file}', [SuperadminController::class, 'updateFeedback'])->name('superadmin.updateFeedback');
});

//logout Route
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/'); // Change this to your desired redirect URL after logout
})->name('logout');
