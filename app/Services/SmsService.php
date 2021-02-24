<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Models\LogSms;
use Str;
use Carbon\Carbon;

class SmsService {

  protected $baseUrl = env('SMS_SERVICE_BASE_URL');

  public function sendSms($phone, $otp) {
    $start_time = Carbon::now();
    $url = $this->baseUrl . 'oauth2/token';
    $client = new Client(['headers' => ['Content-Type' => 'application/json'], 'verify' => false]);
    $sessionId = Str::uuid();
    $data = [
      'grant_type' => 'client_credentials',
      'client_id' => env('SMS_SERVICE_CLIENT_ID'),
      'client_secret' => env('1848e8eAd77958354030b33B78bcf2e2eF4f373b498ccbec020eF92721fd74ef8dd87b43'),
      'scope' => 'send_brandname_otp',
      'session_id' => $sessionId
    ];

    $res = [];
    try {
      $res = $client->post($url, [ 'json' => $data ]);
    } catch (GuzzleException $e) {
      $response = $e->getResponse();
      $content = $response->getBody()->getContents();
      Log::error('[SMS_BRAND] Can not retrieve access_token.', [ 'body' => $content]);
      
      // TODO: Log SMS
      $this->saveLogSms($start_time, $sessionId, $url, $phone, $otp, $data, $response->getStatusCode(), json_decode($content));
      return;
    }

    // in case success
    $content = json_decode($res->getBody());
    $token = $content->access_token;
    // $this->saveLogSms($start_time, $sessionId, $url, $phone, $otp, $data, $res->getStatusCode(), $content);

    // Send OTP
    $message = 'Ma OTP cua ban la ' . $otp;
    $this->pushBrandOtp($client, $token, $sessionId, $phone, $otp, $message);
  }

  public function pushBrandOtp($client, $token, $sessionId, $phone, $otp, $message) {
    $start_time = Carbon::now();
    $url = $this->baseUrl . 'api/push-brandname-otp';
    $data = [
      'access_token' => $token,
      'session_id' => $sessionId,
      'BrandName' => 'FTI',
      'Phone' => $phone,
      'Message' => base64_encode($message)
    ];

    $res = [];
    try {
      $res = $client->post($url, [ 'json' => $data ]);
    } catch (GuzzleException $e) {
      $response = $e->getResponse();
      $content = $response->getBody()->getContents();
      Log::error('[SMS_BRAND] Can not push sms.', [ 'body' => $content]);
      // TODO: Log SMS
      $this->saveLogSms($start_time, $sessionId, $url, $phone, $otp, $data, $response->getStatusCode(), json_decode($content));
      return;
    }

    // in case success
    $content = $res->getBody()->getContents();
    $this->saveLogSms($start_time, $sessionId, $url, $phone, $otp, $data, $res->getStatusCode(), json_decode($content));
  }

  private function saveLogSms($start_time, $sessionId, $url, $phone, $otp, $data, $statusCode, $content) {
    $log = new LogSms();
    $log->session_id = $sessionId;
    $log->request_type = 'SMS_BRAND';
    $log->url = $url;
    $log->phone = $phone;
    $log->otp = $otp;
    $log->request_body = json_encode($data);
    $log->status_code = $statusCode;
    if ($statusCode != 200) {
      $log->error = $content->error;
      $log->error_description = $content->error_description;
    } else {
      $log->message_id = $content->MessageId;
      $log->partner_id = $content->PartnerId;
      $log->tel_co = $content->Telco;
    }
    $log->response_body = json_encode($content);
  
    $log->save();
  }

  private function convert_utf8($str) {
    $result = mb_convert_encoding(
        preg_replace("/\\\\u([0-9a-f]{4})/"
            ,"&#x\\1;"
            ,$str
        )
        ,"UTF-8"
        ,"HTML-ENTITIES"
    );
    return $result;
  }
}