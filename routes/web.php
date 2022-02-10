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

Route::get('/',[App\Http\Controllers\HomeController::class,'index'])->name('home');

//Admin Routes
Route::get('admin',function () {
    return redirect()->route('admin.login');
});
Route::get('admin/login',[App\Http\Controllers\Admin\Auth\LoginController::class,'showLoginForm'])->name('admin.login');
Route::post('admin/login',[App\Http\Controllers\Admin\Auth\LoginController::class,'login']);
Route::get('admin/dashboard',[App\Http\Controllers\Admin\HomeController::class,'dashboard'])->name('admin.dashboard');
Route::get('admin/logout',[App\Http\Controllers\Admin\HomeController::class,'logout'])->name('admin.logout');

Route::get('admin/users',[App\Http\Controllers\Admin\HomeController::class,'users'])->name('admin.users');
Route::get('admin/users/add',[App\Http\Controllers\Admin\HomeController::class,'addUser'])->name('admin.user.add');
Route::post('admin/users/add',[App\Http\Controllers\Admin\HomeController::class,'addUserReg']);

Route::get('admin/profile',[App\Http\Controllers\Admin\HomeController::class,'profile'])->name('admin.profile');


//USER ROUTES
Route::get('user',function () {return redirect()->route('user.login');});

// USER REGISTRATION / LOGIN
Route::get('user/login',[App\Http\Controllers\User\Auth\LoginController::class,'showLoginForm'])->name('user.login');
Route::any('user/register',[App\Http\Controllers\User\Auth\LoginController::class,'showRegistrationForm'])->name('user.register');

// USER RESET PASSWORD
Route::get('user/password/reset/email',[App\Http\Controllers\User\Auth\ResetPasswordController::class,'email'])->name('user.reset_password_email');
Route::post('user/password/reset',[App\Http\Controllers\User\Auth\ResetPasswordController::class,'reset'])->name('user.reset_password');
Route::get('user/password/confirm',[App\Http\Controllers\User\Auth\ResetPasswordController::class,'confirm'])->name('user.confirm_password');

// PAYMENT
Route::any('user/payment',[App\Http\Controllers\User\Auth\LoginController::class,'showPaymentForm'])->name('user.payment');
Route::any('user/payment/success',[App\Http\Controllers\User\Auth\LoginController::class,'paymentSuccess'])->name('user.payment.success');
Route::any('user/payment/failure',[App\Http\Controllers\User\Auth\LoginController::class,'paymentFailure'])->name('user.payment.failure');
Route::any('user/stripe',[App\Http\Controllers\User\Auth\LoginController::class,'handlePost'])->name('user.stripe');

// USER DASHBOARD
Route::get('user/dashboard',[App\Http\Controllers\User\HomeController::class,'dashboard'])->name('user.dashboard');
Route::get('user/logout',[App\Http\Controllers\User\HomeController::class,'logout'])->name('user.logout');
Route::get('user/verify/mail/{token}',[App\Http\Controllers\HomeController::class,'verifyEmail']);

// USER PROFILE
Route::get('user/profile',[App\Http\Controllers\User\ProfileController::class,'index'])->name('user.profile');

// USER SETTINGS
Route::get('user/settings',[App\Http\Controllers\User\SettingsController::class,'index'])->name('user.settings');

// USER TOOLS
Route::get('user/tools',[App\Http\Controllers\User\ToolsController::class,'index'])->name('user.tools');

//Error messages page
Route::get('no-access',[App\Http\Controllers\HomeController::class,'noaccess'])->name('notauthorised');
Route::get('page-not-found',[App\Http\Controllers\HomeController::class,'pageNotFound'])->name('pagenotfound');