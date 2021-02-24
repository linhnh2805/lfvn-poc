<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use \Illuminate\Http\Request;
use App\Models\Personal;
use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Services\SmsService;

class Step4Controller extends Controller {

  public function requestOtp(Request $request) {
    $reserveId = $request->input('reserve_id');
    $phoneNumber = $request->input('phone_number');

    $personal = Personal::where('reserve_id', $reserveId)->first();

    $contact = new Contact();
    $contact->personal_id = $personal->id;
    $contact->reserve_id = $reserveId;
    $contact->phone_number = $phoneNumber;
    $contact->otp = rand(100000, 999999);
    $contact->status = 'ACTIVATING';
    $contact->start_time = Carbon::now();
    $contact->expire_time = Carbon::now()->addSeconds(120);
    $contact->save();

    // Send OTP
    $smsService = new SmsService();
    $smsService->sendSms($contact->phone_number, $contact->otp);

    return response()->json([
      'code' => 'OK',
      'timeout' => 120
    ]);
  }

  public function postOtp(Request $request) {
    $reserveId = $request->input('reserve_id');
    $phoneNumber = $request->input('phone_number');
    $otp = $request->input('otp');

    $contact = Contact::where('reserve_id', $reserveId)
        ->where('phone_number', $phoneNumber)
        ->where('otp', $otp)
        ->first();
    
    if (!$contact) {
      return response()->json(['code' => 'Wrong OTP!' ]);
    } elseif ($contact->status != 'ACTIVATING') {
      return response()->json(['code' => 'OTP is not valid!' ]);
    } elseif ($contact->expire_time->lt(Carbon::now())) {
      $contact->status = 'EXPIRED';
      $contact->save();
      return response()->json(['code' => 'OTP is expired!' ]);
    }

    $contact->status = 'DONE';
    // $contact->cic_credit_check = 'PENDING';
    $contact->save();
    
    return response()->json([
      'code' => 'OK'
    ]);
  }
}