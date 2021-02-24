<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Models\Personal;
use App\Models\Contact;
use App\Models\LogCic;
use Carbon\Carbon;

class CreditService {

  protected $url = env('CREDIT_BASE_URL') . '/score';

  public function checkCredit($personal) {
    $startTime = Carbon::now();
    $contact = $personal->contacts[0];
    $purpose = $personal->purposes[0];
    $disbursement = $personal->disbursements[0];
    $data = [
      'personalID' => $personal->national_id, 'personalName' => $personal->full_name,
      'location' => $personal->issue_at, 'stateOrProvince' => $personal->province, 'country' => 'VN',
      'email' => $contact->email, 'mobile' => $contact->phone_number,
      'loanAmount' => $purpose->lending_amount, 'loanTenor' => $purpose->lending_length, 
      'loanPayOffDate' => '', 'loanPurpose' => $purpose->lending_purpose,
      'accountName' => $disbursement->account_owner, 'accountNumber' => $disbursement->account_number,
      'bankCode' => $disbursement->bank_name, 'brandCode' => $disbursement->branch_name,
      'isAutoDisbursement' => true,
      'birthDay' => $personal->birthday,
      'address1' => $personal->address,
      'address2' => ''
    ];

    $res = [];
    try {
      $client = new Client(['headers' => [
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer ' . env('CREDIT_AUTHORIZATION_TOKEN')
        ]]);
      $res = $client->post($this->url, ['json' => $data]);
    } catch (GuzzleException $e) {
      $response = $e->getResponse();
      $content = $response->getBody()->getContents();
      Log::error('[CREDIT CHECK] Check credit error with code: ' . $response->getStatusCode(), ['content' => $content]);
      $this->saveLogCic($startTime, $this->url, $contact->id, $personal->id, $data, $response->getStatusCode(), $content);
      return -1;
    }

    $content = json_decode($res->getBody());
    $fcmService = new FcmService();
    $title = "Thông báo!";
    if ($content->code == 0) {
      // Update personal & contact
      $personal->cic_credit_check = 'OK';
      $personal->save();
      // Send FCM
      $message = "Đăng ký thành công!";
      $action = "ON_NOTIFY_SUCCESS";
      $fcmService->sendNotification($personal->device_token, $title, $message, $action);
    } else {
      // Update personal & contact
      $personal->cic_credit_check = 'FAIL';
      $personal->save();
      // Send FCM
      $message = "Đăng ký không thành công!";
      $action = "ON_NOTIFY_FAIL";
      $fcmService->sendNotification($personal->device_token, $title, $message, $action);
    }

    $this->saveLogCic($startTime, $this->url, $contact->id, $personal->id, $data, $res->getStatusCode(), $content);
  }

  private function saveLogCic($startTime, $url, $contactId, $personalId, $data, $statusCode, $content) {
      $log = new LogCic();
      $log->start_time = $startTime;
      $log->request_type = 'CREDIT_CHECK';
      $log->url = $url;
      $log->personal_id = $personalId;
      $log->contact_id = $contactId;
      $log->status_code = $statusCode;
      $log->request_body = json_encode($data);
      $log->response_body = json_encode($content);
      $log->save();
  }
}