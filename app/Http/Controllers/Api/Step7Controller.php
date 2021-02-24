<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Personal;
use App\Models\Contact;
use App\Models\Disbursement;
use App\Models\Finance;
use App\Models\Payment;
use App\Models\Purpose;
use App\Models\Residence;
use DB;
use Illuminate\Support\Facades\Log;

class Step7Controller extends Controller {

  function postInformation(Request $request) {
    $reserve_id = $request->input('reserve_id');

    // Update Personal
    $personalInfo = $request->personal;
    $personal = Personal::where('reserve_id', $reserve_id)->first();
    $personal->job = $personalInfo['job'];
    $personal->education = $personalInfo['education'];
    $personal->job_position = $personalInfo['job_position'];
    $personal->marital_status = $personalInfo['marital_status'];
    $personal->old_national_id = $personalInfo['old_national_id'];
    $personal->passport = $personalInfo['passport'];
    $personal->is_lend = $personalInfo['is_lend'];
    $otherAgreement = $request->other_agreement;
    $personal->agreement_usage_information = $otherAgreement['usage_information'];
    $personal->agreement_receive_advertise = $otherAgreement['receive_advertise'];
    $personal->cic_fraud_check = 'PENDING';
    $personal->cic_credit_check = 'PENDING';
    $personal->device_token = $personalInfo['device_token'];

    // Create Residence
    $residence = new Residence();
    $residenceInfo = $request->residence;
    $residence->personal_id = $personal->id;
    $residence->current_address = $residenceInfo['current_address'];
    $residence->current_province = $residenceInfo['current_province'];
    $residence->residence_same_as_address = $residenceInfo['residence_same_as_address'];
    $residence->residence_address = $residenceInfo['residence_address'];
    $residence->residence_province = $residenceInfo['residence_province'];
    $residence->residence_start_date = $residenceInfo['residence_start_date'];
    $residence->residence_status = $residenceInfo['residence_status'];

    // Update Contact
    $contactInfo = $request->contact;
    $contact = Contact::where('reserve_id', $reserve_id)->where('status', 'DONE')->first();
    $contact->personal_id = $personal->id;
    $contact->email = $contactInfo['email'];
    $contact->phone_number = $contactInfo['phone_number'];
    $contact->second_phone_number = $contactInfo['second_phone_number'];
    $contact->available_time = $contactInfo['available_time'];
    $contact->first_reference_name = $contactInfo['first_reference_name'];
    $contact->first_reference_national_id = $contactInfo['first_reference_national_id'];
    $contact->first_reference_relationship = $contactInfo['first_reference_relationship'];
    $contact->first_reference_phone_number = $contactInfo['first_reference_phone_number'];
    $contact->second_reference_name = $contactInfo['second_reference_name'];
    $contact->second_reference_national_id = $contactInfo['second_reference_national_id'];
    $contact->second_reference_relationship = $contactInfo['second_reference_relationship'];
    $contact->second_reference_phone_number = $contactInfo['second_reference_phone_number'];
    $contact->cic_credit_check = 'PENDING';
    // $contact->save();

    // Create Finance
    $finance = new Finance();
    $financeInfo = $request->finance;
    $finance->personal_id = $personal->id;
    $finance->check_income_agreement = $financeInfo['check_income_agreement'];
    $finance->income_type = $financeInfo['income_type'];
    $finance->company_name = $financeInfo['company_name'];
    $finance->company_phone_number = $financeInfo['company_phone_number'];
    $finance->company_address = $financeInfo['company_address'];
    $finance->company_province = $financeInfo['company_province'];
    $finance->contract_length = $financeInfo['contract_length'];
    $finance->job_type = $financeInfo['job_type'];
    $finance->monthly_income = $financeInfo['monthly_income'];
    $finance->receive_type = $financeInfo['receive_type'];
    $finance->start_job_date = $financeInfo['start_job_date'];
    $finance->monthly_cost = $financeInfo['monthly_cost'];
    $finance->dependent_person = $financeInfo['dependent_person'];

    // Create Purpose
    $purpose = new Purpose();
    $purposeInfo = $request->purpose;
    $purpose->personal_id = $personal->id;
    $purpose->lending_amount = $purposeInfo['lending_amount'];
    $purpose->lending_length = $purposeInfo['lending_length'];
    $purpose->lending_purpose = $purposeInfo['lending_purpose'];
    $purpose->payment_date = $purposeInfo['payment_date'];
    $purpose->secure_lending_info = $purposeInfo['secure_lending_info'];
    $purpose->loan_insurance = $purposeInfo['loan_insurance'];

    // Create Disbursement
    $disbursement = new Disbursement();
    $disbursementInfo = $request->disbursement;
    $disbursement->personal_id = $personal->id;
    $disbursement->disbursement_method = $disbursementInfo['disbursement_method'];
    $disbursement->account_owner = $disbursementInfo['account_owner'];
    $disbursement->account_number = $disbursementInfo['account_number'];
    $disbursement->bank_name = $disbursementInfo['bank_name'];
    $disbursement->branch_name = $disbursementInfo['branch_name'];

    // Create Payment
    $payment = new Payment();
    $paymentInfo = $request->payment;Log::info($paymentInfo);
    $payment->personal_id = $personal->id;
    $payment->auto_charge_to_account = $paymentInfo['auto_charge_to_account'];
    $payment->account_owner = $paymentInfo['account_owner'] ?? "";
    $payment->account_number = $paymentInfo['account_number'] ?? "";
    $payment->bank_name = $paymentInfo['bank_name'] ?? "";
    $payment->branch_name = $paymentInfo['branch_name'] ?? "";
    $payment->payment_type = $paymentInfo['payment_type'] ?? "";
    $payment->payment_cash_type = $paymentInfo['payment_cash_type'] ?? "";

    DB::transaction(function () use ($personal, $residence, $contact, $finance, $purpose, $disbursement, $payment) {
      $personal->save();
      $residence->save();
      $contact->save();
      $finance->save();
      $purpose->save();
      $disbursement->save();
      $payment->save();
    });

    //

    return response()->json([
      'code' => 'OK'
    ]);
  }
}