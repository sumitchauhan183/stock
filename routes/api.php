<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// ADMIN API ROUTES
Route::POST('admin/login',[App\Http\Controllers\Api\AdminController::class,'login']);
Route::POST('admin/mail/check',[App\Http\Controllers\Api\AdminController::class,'checkEmail']);

// USER API Routes
Route::post('email/check',[App\Http\Controllers\API\UserController::class,'checkEmail']);
Route::post('otp/check',[App\Http\Controllers\API\UserController::class,'checkOTP']);
Route::post('userid/check',[App\Http\Controllers\API\UserController::class,'checkUserId']);
Route::post('user/register',[App\Http\Controllers\API\UserController::class,'registerUser']);
Route::post('user/login',[App\Http\Controllers\API\UserController::class,'loginUser']);
Route::post('user/send/verify/mail/{user_id}',[App\Http\Controllers\API\UserController::class,'sendVerifyMail']);
Route::post('user/send/otp/mail/{email}',[App\Http\Controllers\API\UserController::class,'sendOtpMail']);
Route::post('user/resend/otp/{user_id}',[App\Http\Controllers\API\UserController::class,'resendOtpMail']);
Route::post('user/reset/password',[App\Http\Controllers\API\UserController::class,'resetPassword']);
Route::post('user/change/password',[App\Http\Controllers\API\UserController::class,'changePassword']);
Route::post('user/profile/update',[App\Http\Controllers\API\UserController::class,'updateProfile']);

// CRON APIS
Route::get('cron/companies/save/{key}',[App\Http\Controllers\API\CronController::class,'saveCompanies']);
Route::get('cron/companies/EPV/save/{key}',[App\Http\Controllers\API\CronController::class,'saveEPV']);
Route::get('cron/companies/detail/save/{key}',[App\Http\Controllers\API\CronController::class,'saveCompanyDetail']);



// INTRINIO API
Route::any('find-value-stock/sector/{sector}',[App\Http\Controllers\API\Intrinio\FVSController::class,'companies']);
Route::any('find-value-stock/sector/company/{id}',[App\Http\Controllers\API\Intrinio\FVSController::class,'companyDetail']);



