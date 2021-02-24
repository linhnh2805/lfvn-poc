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
use Str;
use App\Services\FcmService;

class CicService {

  public function process() {
    // Gather un-check
    $contacts = Contact::where('cic_credit_check', 'PENDING')->get();
    if (sizeof($contacts) == 0) return;

    // Setup
    $client = new Client(['headers' => ['Content-Type' => 'application/json'], 'verify' => false]);
    // Get token
    $url = env('CIC_DATA_BASE_URL') . '/v2/token';
    $res = $client->post($url, [
        'json' => [
            "client_code" => env('CIC_DATA_CLIENT_CODE'),
            "client_secret" => env('CIC_DATA_CLIENT_SECRET')
        ]
    ]);
    if ($res->getStatusCode() != 200) {
        Log::error('[CIC_CHECK] Can not retrieve access_token. Status code: ' . $res->getStatusCode());
        return 0;
    }
    $content = json_decode($res->getBody());
    if ($content->error->code != 0) {
        Log::error('[CIC_CHECK] Get AccessToken error with code: ' . $content->error->code . ' and message: ' . $content->error->message);
    }
    $cicToken = $content->data->access_token;

    $fcmService = new FcmService();
    // Check credit score: /v2/r/credit/query/
    foreach ($contacts as $contact) {
        $credit = $this->credit_check($client, $cicToken, $contact);
        $fraud = $this->fraud_check($client, $cicToken, $contact, $contact->person);

        $title = "Thông báo!";
        if ($credit && $fraud) {
            $message = "Đăng ký thành công!";
            $action = "ON_NOTIFY_SUCCESS";
            $fcmService->sendNotification($contact->person->device_token, $title, $message, $action);
        } else if (!$credit || !$fraud) {
            $message = "Đăng ký không thành công!";
            $action = "ON_NOTIFY_FAIL";
            $fcmService->sendNotification($contact->person->device_token, $title, $message, $action);
        }
    }
  }

  private function credit_check($client, $token, $contact) {
    $url = env('CIC_DATA_BASE_URL') . '/v2/r/credit/query/';
    $uuid = Str::uuid();
    $requestBody = [
        "request_id" => $uuid,
        "phone_number" => $contact->phone_number,
        "product" => "personal_loan",
        "channel" => "walk_in",
        "score_version" => "stable",
        "national_id" => $contact->person->national_id,
    ];
    $res = $client->post($url, [
        'headers' => ['Authorization' => 'Bearer ' . $token],
        'verify' => false,
        'json' => $requestBody
    ]);

    if ($res->getStatusCode() == 200) {
        $content = json_decode($res->getBody());
        $this->gatherLogCic($uuid, 'CIC_CREDIT', $url, $contact->person->national_id, 
        $contact->id, $requestBody, $res->getStatusCode(), $content);
        if ($content->error->code == 0) {
            $contact->cic_credit_check = 'OK';
            $contact->cic_credit_check_message = $content->error->message;
            $contact->save();
            return true;
        } else {
            $contact->cic_credit_check = 'FAIL';
            $contact->cic_credit_check_message = $content->error->message;
            $contact->save();
            return false;
        }
    } else {
        Log::error('[CIC_CHECK] Can not call CIC Service for contact: ' . $contact->id);
        $this->gatherLogCic($uuid, 'CIC_CREDIT', $url, $contact->person->national_id, 
        $contact->id, $requestBody, $res->getStatusCode());
    }
  }

  private function fraud_check($client, $token, $contact, $personal) {
      $url = env('CIC_DATA_BASE_URL') . '/v2/r/fraud/query/';
      $uuid = Str::uuid();
      $requestBody = [
          "request_id" => $uuid,
          "phone_number" => $contact->phone_number,
          "reference_number" => [$contact->first_reference_phone_number, $contact->second_reference_phone_number],
          "national_id" => $contact->person->national_id,
          "province" => $contact->person->province,
          "district" => $contact->person->district
      ];
      $res = $client->post($url, [
          'headers' => ['Authorization' => 'Bearer ' . $token],
          'verify' => false,
          'json' => $requestBody
      ]);

      if ($res->getStatusCode() == 200) {
          $content = json_decode($res->getBody());
          $this->gatherLogCic($uuid, 'CIC_FRAUD', $url, $contact->person->national_id, 
          $contact->id, $requestBody, $res->getStatusCode(), $content);
          if ($content->error->code == 0) {
              $personal->cic_fraud_check = 'OK';
              $personal->cic_fraud_check_message = $content->error->message;
              $personal->save();
              return true;
          } else {
              $personal->cic_fraud_check = 'FAIL';
              $personal->cic_fraud_check_message = $content->error->message;
              $personal->save();
              return false;
          }
      } else {
          Log::error('[CIC_CHECK] Can not call CIC Service for personal: !' . $personal->id);
          $this->gatherLogCic($uuid, 'CIC_FRAUD', $url, $contact->person->national_id, 
          $contact->id, $requestBody, $res->getStatusCode());
      }
  }

  private function gatherLogCic($uuid, $type, $url, $personalId, $contactId, $requestBody, $statusCode, $content) {
      $log = new LogCic();
      $log->uuid = $uuid;
      $log->request_type = $type;
      $log->url = $url;
      $log->personal_id = $personalId;
      $log->contact_id = $contactId;
      $log->request_body = json_encode($requestBody);
      $log->status_code = $statusCode;
      if ($log->status_code == 200) {
          $log->error_code = $content->error->code;
          $log->error_message = $content->error->message;
          $log->data = json_encode($content->data);
      }
      $log->save();
  }
}