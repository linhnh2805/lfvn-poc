<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Personal;
use App\Models\Residence;
use App\Models\Contact;
use Illuminate\Support\Facades\Log;
use App\Util\ConverterUtil;
use Storage;
use Session;
use App\Client\NationalIdRecognition;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class OnboardingController extends Controller {

  public function step1(Request $request) {

    return view('onboarding.step1');
  }

  public function step1_post(Request $request) {

	$validatedData = $request->validate([
      'front' => 'required',
      'back' => 'required',
      'portrait' => 'required',
      'g-recaptcha-response' => 'required|recaptchav3:onboarding,0.5'
	]);

    if (is_null($request->file('front')) || is_null($request->file('back')) || is_null($request->file('portrait'))) {
      return back()->with('error', 'Please upload images!');
    }

    $reserve_id = uniqid();

    $front = $request->file('front')->storeAs('public/user_images', $reserve_id .'_front.png');
    $back = $request->file('back')->storeAs('public/user_images', $reserve_id . '_back.png');
    $portrait = $request->file('portrait')->storeAs('public/user_images', $reserve_id . '_portrait.png');

    $personal = new Personal();
    $personal->reserve_id = $reserve_id;
    $personal->status = 'DRAFT';
    $personal->save();

    // Setup variable
    $front_path = 'public/user_images/' . $reserve_id .'_front.png';
    $back_path = 'public/user_images/' . $reserve_id .'_back.png';
    $portrait_path = 'public/user_images/' . $reserve_id .'_portrait.png';
    
    try {
      $result_code = 'OK';
      $nationalCheck = new NationalIdRecognition();
      $result_code_1 = $nationalCheck->mockSuccessNationalId($front_path, $back_path, $personal);
      if ($result_code_1 == 'OK') {
        $personal->save();
      } else {
        $result_code = $result_code_1;
      }
      
      $result_code_2 = $nationalCheck->mockSuccessPortrait($front_path, $portrait_path, $personal);
      if ($result_code_2 == 'OK') {
        $personal->face_status = 'OK';
        $personal->face_score = 0.56;
        $personal->save();
      } else {
        $result_code = $result_code . '\n' . $result_code_2;
      }

    } catch (\GuzzleHttp\Exception\RequestException $e) {
      Log::info($e);
    }

    if ($result_code == 'OK') {
      return redirect()->route('step2', ['reserve_id' => $reserve_id])->with(['reserve_id' => $reserve_id, 'personal' => $personal]);
    } else {
      return back()->with('error', $result_code);
    }
  }

  public function step2(Request $request) {
    $reserve_id = Session::get('reserve_id') ?: $request->reserve_id;
    $personal = Personal::where('reserve_id', $reserve_id)->first();
    return view('onboarding.step2', ['reserve_id' => $reserve_id, 'personal' => $personal]);
  }

  public function step2_post(Request $request) {
	$validatedData = $request->validate([
      'job' => 'required',
      'education' => 'required',
      'job_position' => 'required',
      'marital_status' => 'required',
      'g-recaptcha-response' => 'required|recaptchav3:onboarding,0.5'
	]);
    $reserve_id = Session::get('reserve_id') ?: $request->reserve_id;
    $personal = Personal::where('reserve_id', $reserve_id)->first();
    $result_code = 'OK';

    // Update Personal
    $personal->job = $request->job;
    $personal->education = $request->education;
    $personal->job_position = $request->job_position;
    $personal->marital_status = $request->marital_status;
    $personal->old_national_id = $request->old_national_id;
    $personal->passport = $request->passport;
    $personal->cic_fraud_check = 'PENDING';
    $personal->cic_credit_check = 'PENDING';
    $personal->save();

    if ($result_code == 'OK') {
      return redirect()->route('step3', ['reserve_id' => $reserve_id])->with(['reserve_id' => $reserve_id]);
    } else {
      return back()->with('error', $result_code);
    }
  }

  public function step3(Request $request) {
    $reserve_id = Session::get('reserve_id') ?: $request->reserve_id;
    $personal = Personal::where('reserve_id', $reserve_id)->first();

    return view('onboarding.step3', ['reserve_id' => $reserve_id]);
  }

  public function step3_post(Request $request) {
	$validatedData = $request->validate([
      'current_address' => 'required',
      'current_province' => 'required',
      'residence_address' => 'required',
      'residence_province' => 'required',
      'residence_start_date' => 'required',
      'residence_status' => 'required',
      'g-recaptcha-response' => 'required|recaptchav3:onboarding,0.5'
	]);
    $reserve_id = Session::get('reserve_id') ?: $request->reserve_id;
    $personal = Personal::where('reserve_id', $reserve_id)->first();
    $result_code = 'OK';

    // Create Residence
    $residence = new Residence();
    $residence->personal_id = $personal->id;
    $residence->current_address = $request->current_address;
    $residence->current_province = $request->current_province;
    $residence->residence_same_as_address = $request->residence_same_as_address == 'on' ? 1 : 0;
    $residence->residence_address = $request->residence_address;
    $residence->residence_province = $request->residence_province;
    $residence->residence_start_date = $request->residence_start_date;
    $residence->residence_status = $request->residence_status;
    $residence->save();

    if ($result_code == 'OK') {
      return redirect()->route('step4', ['reserve_id' => $reserve_id])->with(['reserve_id' => $reserve_id]);
    } else {
      return back()->with('error', $result_code);
    }
  }

  public function step4(Request $request) {
    $reserve_id = Session::get('reserve_id') ?: $request->reserve_id;

    return view('onboarding.step4', ['reserve_id' => $reserve_id]);
  }

  public function step4_post(Request $request) {
	$validatedData = $request->validate([
      'email' => 'required',
      'phone_number' => 'required',
      'available_time' => 'required',
      'first_reference_name' => 'required',
      'first_reference_phone_number' => 'required',
      'first_reference_national_id' => 'required',
      'first_reference_relationship' => 'required',
      'second_reference_name' => 'required',
      'second_reference_phone_number' => 'required',
      'second_reference_national_id' => 'required',
      'second_reference_relationship' => 'required',
      'g-recaptcha-response' => 'required|recaptchav3:onboarding,0.5'
	]);
    $reserve_id = Session::get('reserve_id') ?: $request->reserve_id;
    $personal = Personal::where('reserve_id', $reserve_id)->first();
    $result_code = 'OK';

    // Check exist
    $user = User::where('email', $request->email)->first();
    if ($user) {
      return back()->with('error', 'Email đã được đăng ký!');
    }
    $user = User::where('name', $request->phone_number)->first();
    if ($user) {
      return back()->with('error', 'Số điện thoại đã được đăng ký!');
    }

    // Update Contact
    $contact = new Contact();
    $contact->personal_id = $personal->id;
    $contact->reserve_id = $reserve_id;
    $contact->phone_number = $request->phone_number;
    $contact->email = $request->email;
    $contact->second_phone_number = $request->second_phone_number;
    $contact->available_time = $request->available_time;
    $contact->first_reference_name = $request->first_reference_name;
    $contact->first_reference_national_id = $request->first_reference_national_id;
    $contact->first_reference_relationship = $request->first_reference_relationship;
    $contact->first_reference_phone_number = $request->first_reference_phone_number;
    $contact->second_reference_name = $request->second_reference_name;
    $contact->second_reference_national_id = $request->second_reference_national_id;
    $contact->second_reference_relationship = $request->second_reference_relationship;
    $contact->second_reference_phone_number = $request->second_reference_phone_number;
    $contact->cic_credit_check = 'PENDING';
    $contact->save();
    
    // Update Personal
    $personal->username = $request->phone_number;
    $personal->password = '123456';
    $personal->save();

    if ($result_code == 'OK') {
      return redirect()->route('step-review', ['reserve_id' => $reserve_id])->with(['reserve_id' => $reserve_id]);
    } else {
      return back()->with('error', $result_code);
    }
  }

  public function step_review(Request $request) {
    $reserve_id = $request->reserve_id;
    $personal = Personal::where('reserve_id', $reserve_id)->first();
    $contact = Contact::where('reserve_id', $reserve_id)->first();
    $residence = Residence::where('personal_id', $personal->id)->first();

    return view('onboarding.step-review', compact('reserve_id', 'personal', 'contact', 'residence'));
  }

  public function step_review_post(Request $request) {
    $reserve_id = $request->reserve_id;
    $personal = Personal::where('reserve_id', $reserve_id)->first();
    $contact = Contact::where('reserve_id', $reserve_id)->first();
    $residence = Residence::where('personal_id', $personal->id)->first();
    $personal->status = 'SUBMITTED';
    
    // Create new User
    $user = new User();
    $user->name = $contact->phone_number;
    $user->email = $contact->email;
    $user->password = Hash::make('123456');
    $user->save();

    $personal->user_id = $user->id;
    $personal->save();

    # MOCK DECISION ENGINE

    $contact = Contact::where('reserve_id', $reserve_id)->first();

    return view('onboarding.step-completed', ['personal' => $personal, 'residence' => $residence]);
  }

  public function step_final(Request $request) {
    return view('onboarding.step-final');
  }
}