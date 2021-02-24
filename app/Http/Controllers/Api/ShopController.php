<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Personal;
use Illuminate\Support\Facades\Log;
use App\Util\ConverterUtil;
use Storage;
// use Illuminate\Support\Facades\Http;


class ShopController extends Controller {

  public function process_payment(Request $request) {
    $order_id = $request->order_id;
    $ref = $request->ref;

    // Call to http://lfvn-shop.local/wc-api/lfvn/
    $url = 'http://lfvn-shop.local/wc-api/lfvn/';
    // $response = Http::get($url);
    $data = [
      'api_token' => env('api_token'),
      'order_id' => $order_id,
      'ref' => $ref
    ];

    $client = new GuzzleHttp\Client();
    $res = $client->post($url, $data);
    #echo $res->getStatusCode(); // 200
    #echo $res->getBody(); // { "type": "User", ....

    return $res->getStatusCode();
  }
}