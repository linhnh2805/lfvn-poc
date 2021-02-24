<?php

namespace App\Client;

use Illuminate\Support\Facades\Log;
use App\Util\ConverterUtil;
use Storage;

class NationalIdRecognition {

  
  /**
   * 
   * @personal (App\Models\Personal)
   */
  public function checkNationalId($front_path, $back_path, $personal) {

    $id_url = env('ID_RECOGNITION_URL');
    $face_url = env('FACE_RECOGNITION_URL');
    $apiKey = env('FACE_RECOGNITION_KEY');
    $result_code = 'OK';
    $client = new \GuzzleHttp\Client(['headers' => ['api-key' => $apiKey]]);
    $response = $client->post( $id_url, [
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
      $personal->dob = ConverterUtil::change_format($cmnd->birthday);
      $personal->district = $cmnd->district;
      $personal->ethnicity = $cmnd->ethnicity;
      $personal->expiry = ConverterUtil::change_format($cmnd->expiry);
      $personal->home_town = $cmnd->home_town;
      $personal->issue_at = $cmnd->issue_at;
      $personal->issue_date = ConverterUtil::change_format($cmnd->issue_date);
      $personal->province = $cmnd->province;
      $personal->religion = $cmnd->religion;
      $personal->sex = $cmnd->sex;
      $personal->ward = $cmnd->ward;
      $personal->national_id = $cmnd->id;
      $personal->logiccheck = $cmnd->logiccheck;
      $personal->logicmessage = $cmnd->logicmessage;
      // $personal->save();
    } else {
      $result_code = 'Can not check ORC: '. $cmnd->logicmessage;
    }

    return $result_code;
  }

  public function mockSuccessNationalId($front_path, $back_path, $personal) {

    $result_code = 'OK';
    
    Log::info('Mock up success response: ');

    $personal->full_name = 'NGUYEN HOANG LONG';
    $personal->first_name = 'HOANG LONG';
    $personal->last_name = 'NGUYEN';
    $personal->address = '84 Duy Tan';
    $personal->dob = '1998-12-31';
    $personal->district = '';
    $personal->ethnicity = '';
    $personal->expiry = '';
    $personal->home_town = 'Cau giay - Ha Noi';
    $personal->issue_at = 'Cau Giay - Ha Noi';
    $personal->issue_date = '2014-03-14';
    $personal->province = 'Ha Noi';
    $personal->religion = '';
    $personal->sex = 'Male';
    $personal->ward = '';
    $personal->national_id = '07894561234';
    $personal->logiccheck = 'OK';
    $personal->logicmessage = '';
      // $personal->save();

    return $result_code;
  }

  public function checkPortrait($front_path, $portrait_path, $personal) {
    $face_url = env('FACE_RECOGNITION_URL');
    $apiKey = env('FACE_RECOGNITION_KEY');
    $result_code = 'OK';
    $client = new \GuzzleHttp\Client(['headers' => ['api-key' => $apiKey]]);

    $res = $client->post($face_url, [
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
    $content = $res->getBody();
    Log::info('Second response:');
    Log::info($content);
    $face = json_decode($content);

    if ($face->result_code == 200) {
      $personal->face_status = 'OK';
      $personal->face_score = $face->score;
    } else {
      $result_code = 'Can not compare face: ' . $face->message;
    }

    return $result_code;
  }

  public function mockSuccessPortrait($front_path, $portrait_path, $personal) {
    $result_code = 'OK';
    
    $personal->face_status = 'OK';
    $personal->face_score = '95';

    return $result_code;
  }
}