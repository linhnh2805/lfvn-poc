<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Personal;
use Illuminate\Support\Facades\Log;
use App\Util\ConverterUtil;
use Storage;

class Step1Controller extends Controller {

  function uploadNationalId(Request $request) {
    $reserve_id = uniqid();

    $front = $request->file('front')->storeAs('public/user_images', $reserve_id .'_front.png');
    $back = $request->file('back')->storeAs('public/user_images', $reserve_id . '_back.png');
    $portrait = $request->file('portrait')->storeAs('public/user_images', $reserve_id . '_portrait.png');

    $personal = new Personal();
    $personal->reserve_id = $reserve_id;
    $personal->save();
    
    // Setup variable
    $url = env('ID_RECOGNITION_URL');
    $url2 = env('FACE_RECOGNITION_URL');
    $apiKey = env('ID_RECOGNITION_KEY');
    $front_path = 'public/user_images/' . $reserve_id .'_front.png';
    $back_path = 'public/user_images/' . $reserve_id .'_back.png';
    $portrait_path = 'public/user_images/' . $reserve_id .'_portrait.png';

    // Call to service
    $result_code = 'OK';
    $client = new \GuzzleHttp\Client(['headers' => ['api-key' => $apiKey]]);
    try {
      $response = $client->post( $url, [
        'multipart' => [
            [
              'name'     => 'image1',
              'contents' => Storage::get($front_path),
              'filename' => 'front.png'
            ],
            [
              'name'     => 'image2',
              'contents' => Storage::get($back_path),
              'filename' => 'back.png'
            ],
            ['name' => 'encode', 'contents' => '1']
          ],
        ]
      );
      $content = $response->getBody();
  
      Log::info('First response: ');
      Log::info($content);
      $cmnd = json_decode($content);
      if ($cmnd->result_code == 200) {
        $personal->full_name = $cmnd->name;
        $personal->first_name = $cmnd->first_name;
        $personal->last_name = $cmnd->last_name;
        $personal->address = $cmnd->address;
        $personal->birthday = $this->change_format($cmnd->birthday);
        $personal->district = $cmnd->district;
        $personal->ethnicity = $cmnd->ethnicity;
        $personal->expiry = $this->change_format($cmnd->expiry);
        $personal->home_town = $cmnd->home_town;
        $personal->issue_at = $cmnd->issue_at;
        $personal->issue_date = $this->change_format($cmnd->issue_date);
        $personal->province = $cmnd->province;
        $personal->religion = $cmnd->religion;
        $personal->sex = $cmnd->sex;
        $personal->ward = $cmnd->ward;
        $personal->national_id = $cmnd->id;
        $personal->logiccheck = $cmnd->logiccheck;
        $personal->logicmessage = $cmnd->logicmessage;
        $personal->save();
      } else {
        $result_code = 'Can not check ORC: '. $cmnd->logicmessage;
      }

      $res2 = $client->post($url2, [
        'multipart' => [
          [
            'name'     => 'image1',
            'contents' => Storage::get($front_path),
            'filename' => 'front.png'
          ],
          [
            'name'     => 'image2',
            'contents' => Storage::get($portrait_path),
            'filename' => 'poitrait.png'
          ]
        ]
      ]);
      $content2 = $res2->getBody();
      Log::info('Second response:');
      Log::info($content2);
      $face = json_decode($content2);

      if ($face->result_code == 200) {
        $personal->face_status = 'OK';
        $personal->face_score = $face->score;
        $personal->save();
      } else {
        $result_code = $result_code . '\n Can not compare face: ' . $face->message;
      }
    } catch (\GuzzleHttp\Exception\RequestException $e) {
      Log::info($e);
    }

    return response()->json([
      'code' => $result_code,
      'reserve_id' => $reserve_id . '',
      'full_name' => $personal->full_name,
      'gender' => $personal->sex,
      'dob' => $personal->birthday,
      'national_id' => $personal->national_id,
      'issue_date' => $personal->issue_date,
      'issue_location' => $personal->issue_at
    ]);
  }

  function change_format($str) {
    if (empty($str)) return "";

    $date = str_replace('/', '-', $str);
    return date('Y-m-d', strtotime($date));
  }
}