<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PaymentController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [CustomerController::class, 'loginForm']);
Route::post('/login', [CustomerController::class, 'login']);

Route::get('/onboarding', [OnboardingController::class, 'onboarding']);
Route::get('/step1', [OnboardingController::class, 'step1'])->name('step1');
Route::get('/step2', [OnboardingController::class, 'step2'])->name('step2');
Route::get('/step3', [OnboardingController::class, 'step3'])->name('step3');
Route::get('/step4', [OnboardingController::class, 'step4'])->name('step4');
Route::get('/step_review', [OnboardingController::class, 'step_review'])->name('step-review');
Route::get('/step_final', [OnboardingController::class, 'step_final'])->name('step-final');

Route::post('/step1', [OnboardingController::class, 'step1_post'])->name('step1-post');
Route::post('/step2', [OnboardingController::class, 'step2_post'])->name('step2-post');
Route::post('/step3', [OnboardingController::class, 'step3_post'])->name('step3-post');
Route::post('/step4', [OnboardingController::class, 'step4_post'])->name('step4-post');
Route::post('/step_review', [OnboardingController::class, 'step_review_post'])->name('step-review-post');

Route::get('/payment', [PaymentController::class, 'payment']);
Route::post('/payment', [PaymentController::class, 'payment_checkout']);
Route::post('/payment_login', [PaymentController::class, 'payment_login']);
Route::post('/payment_logout', [PaymentController::class, 'payment_logout']);