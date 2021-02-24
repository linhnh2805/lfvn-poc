<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Personal;
use Illuminate\Support\Facades\Log;
use App\Util\ConverterUtil;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class PaymentController extends Controller {

  public function payment(Request $request) {
    $order_id = $request->order_id;
    $ref = $request->ref ?: '';
    $merchant = $request->merchant ?: '';
    $redirect_url = $request->redirect_url;

    if (strcasecmp($merchant, 'techx')==0) {
      // Setup client
      $stack = HandlerStack::create();
      $oauth = new Oauth1(array(
        'consumer_key' => env('MERCHANT_TECHX_API_USER'),
        'consumer_secret' => env('MERCHANT_TECHX_API_SECRET'),
        'token' => '',
        'token_secret' => ''
      ));
      $stack->push($oauth);
      $client = new Client([
        'base_uri' => env('MERCHANT_TECHX_API_URL'),
        'handler' => $stack,
        'auth' => 'oauth'
      ]);

      // Setup variables
      $url = 'orders/' . $order_id;
      $res = $client->get($url);
      $order = json_decode($res->getBody());

      $quantity = 0;
      foreach ($order->line_items as $item) {
        $quantity = $quantity + $item->quantity;
      }

      if (Auth::check()) {
        $personal = Personal::where('user_id', auth()->user()->id)->first();
        return view('payment.billing', ['order' => $order, 'personal' => $personal, 'redirect_url' => $redirect_url, 'quantity' => $quantity]);
      } else {
        return view('payment.billing', ['order' => $order, 'redirect_url' => $redirect_url, 'quantity' => $quantity]);
      }
    } else {
      $request->session()->flash('error', 'Merchant ' . $merchant . ' is not support!');
      return view('payment.billing');
    }
  }

  public function payment_login(Request $request) {
    $customer = Personal::where('username', $request->username)
    ->where('password', $request->password)
    ->where('status', 'ACTIVE')
    ->first();

    if (is_null($customer)) {
      return back()->with('error', 'Login failed!');
    } else {
      $user = \App\Models\User::find($customer->user_id)->first();
      Auth::login($user, true);
      return back()->with('message', 'Login success!');
    }
  }

  public function payment_logout(Request $request) {
    Auth::logout();
    return back();
  }

  public function payment_checkout(Request $request) {
    $otp = $request->otp;
    $order_id = $request->order_id;
    $redirect_url = $request->redirect_url;

    if (is_null($order_id)) {
      return back()->with('error', 'Invalid Order!');
    }

    if ($otp != '098765') {
      return back()->with('error', 'Wrong OTP!');
    }

    // Setup client
    $stack = HandlerStack::create();
    $oauth = new Oauth1(array(
      'consumer_key' => env('MERCHANT_TECHX_API_USER'),
      'consumer_secret' => env('MERCHANT_TECHX_API_SECRET'),
      'token' => '',
      'token_secret' => ''
    ));
    $stack->push($oauth);
    $client = new Client([
      'base_uri' => env('MERCHANT_TECHX_API_URL'),
      'handler' => $stack,
      'auth' => 'oauth'
    ]);

    // Setup variables
    $url = 'orders/' . $order_id;
    $data = ['status' => 'processing'];
    $res = $client->put($url, ['json' => $data]);
    $order = json_decode($res->getBody());
    
    $quantity = 0;
    foreach ($order->line_items as $item) {
      $quantity = $quantity + $item->quantity;
    }

    return view('payment.success', ['order' => $order, 'redirect_url' => $redirect_url, 'quantity' => $quantity])->with('message', 'Payment success!');
  }
}