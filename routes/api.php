<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Step1Controller;
use App\Http\Controllers\Api\Step4Controller;
use App\Http\Controllers\Api\Step7Controller;
use App\Http\Controllers\Api\Step8Controller;
use App\Http\Controllers\Api\ShopController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/step1/national_id', [Step1Controller::class, 'uploadNationalId']);
Route::get('/step4/request_otp', [Step4Controller::class, 'requestOtp']);
Route::post('/step4/post_otp', [Step4Controller::class, 'postOtp']);

Route::post('/step7/post_information', [Step7Controller::class, 'postInformation']);
Route::post('/step8/residence_image', [Step8Controller::class, 'uploadResidenceImage']);
Route::post('/step8/residence_images', [Step8Controller::class, 'uploadResidenceImages']);

Route::get('/order/process_payment', [ShopController::class, 'process_payment']);