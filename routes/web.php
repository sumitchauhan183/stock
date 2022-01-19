<?php

use Illuminate\Support\Facades\Route;

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

//Employee Routes
Route::get('employee',function () {
    return redirect()->route('employee.login');
});
Route::get('/',function () {
    return redirect()->route('employee.login');
});
Route::get('employee/login',[App\Http\Controllers\Employee\Auth\LoginController::class,'showLoginForm'])->name('employee.login');
Route::post('employee/login',[App\Http\Controllers\Employee\Auth\LoginController::class,'login']);
Route::get('employee/dashboard',[App\Http\Controllers\Employee\HomeController::class,'dashboard'])->name('employee.dashboard');
Route::get('employee/logout',[App\Http\Controllers\Employee\HomeController::class,'logout'])->name('employee.logout');

//Admin Routes
Route::get('admin',function () {
    return redirect()->route('admin.login');
});
Route::get('admin/login',[App\Http\Controllers\Admin\Auth\LoginController::class,'showLoginForm'])->name('admin.login');
Route::post('admin/login',[App\Http\Controllers\Admin\Auth\LoginController::class,'login']);
Route::get('admin/dashboard',[App\Http\Controllers\Admin\HomeController::class,'dashboard'])->name('admin.dashboard');
Route::get('admin/logout',[App\Http\Controllers\Admin\HomeController::class,'logout'])->name('admin.logout');

Route::get('admin/employees',[App\Http\Controllers\Admin\HomeController::class,'employees'])->name('admin.employees');
Route::get('admin/employees/add',[App\Http\Controllers\Admin\HomeController::class,'addEmployee'])->name('admin.employee.add');
Route::post('admin/employees/add',[App\Http\Controllers\Admin\HomeController::class,'addEmployeeReg']);

Route::get('admin/trainers',[App\Http\Controllers\Admin\HomeController::class,'trainers'])->name('admin.trainers');
Route::get('admin/trainers/add',[App\Http\Controllers\Admin\HomeController::class,'addTrainer'])->name('admin.trainer.add');
Route::post('admin/trainers/add',[App\Http\Controllers\Admin\HomeController::class,'addTrainerReg']);

Route::get('admin/hrs',[App\Http\Controllers\Admin\HomeController::class,'hrs'])->name('admin.hrs');
Route::get('admin/hrs/add',[App\Http\Controllers\Admin\HomeController::class,'addHr'])->name('admin.hr.add');
Route::post('admin/hrs/add',[App\Http\Controllers\Admin\HomeController::class,'addHrReg']);

Route::get('admin/data',[App\Http\Controllers\Admin\HomeController::class,'data'])->name('admin.data');
Route::get('admin/data/add',[App\Http\Controllers\Admin\HomeController::class,'dataAdd'])->name('admin.data.add');
Route::post('admin/data/add',[App\Http\Controllers\Admin\HomeController::class,'addDataReg']);
Route::get('admin/data/assign',[App\Http\Controllers\Admin\HomeController::class,'dataAssign'])->name('admin.data.assign');
Route::post('admin/data/assign',[App\Http\Controllers\Admin\HomeController::class,'dataAssignApprove']);

Route::get('admin/profile',[App\Http\Controllers\Admin\HomeController::class,'profile'])->name('admin.profile');


//Hr Routes
Route::get('hr',function () {
    return redirect()->route('hr.login');
});
Route::get('hr/login',[App\Http\Controllers\Hr\Auth\LoginController::class,'showLoginForm'])->name('hr.login');
Route::post('hr/login',[App\Http\Controllers\Hr\Auth\LoginController::class,'login']);
Route::get('hr/dashboard',[App\Http\Controllers\Hr\HomeController::class,'dashboard'])->name('hr.dashboard');
Route::get('hr/logout',[App\Http\Controllers\Hr\HomeController::class,'logout'])->name('hr.logout');

//Trainer Routes
Route::get('trainer',function () {
    return redirect()->route('trainer.login');
});
Route::get('trainer/login',[App\Http\Controllers\Trainer\Auth\LoginController::class,'showLoginForm'])->name('trainer.login');
Route::post('trainer/login',[App\Http\Controllers\Trainer\Auth\LoginController::class,'login']);
Route::get('trainer/dashboard',[App\Http\Controllers\Trainer\HomeController::class,'dashboard'])->name('trainer.dashboard');
Route::get('trainer/logout',[App\Http\Controllers\Trainer\HomeController::class,'logout'])->name('trainer.logout');


//Error messages page
Route::get('no-access',[App\Http\Controllers\HomeController::class,'noaccess'])->name('notauthorised');
Route::get('page-not-found',[App\Http\Controllers\HomeController::class,'pageNotFound'])->name('pagenotfound');