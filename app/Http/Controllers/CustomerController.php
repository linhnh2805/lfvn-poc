<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Personal;
use Illuminate\Support\Facades\Log;
use App\Util\ConverterUtil;
use Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;


class CustomerController extends Controller {

  public function loginForm(Request $request) {

    return view('customer.login');
  }

  public function login(Request $request) {
    
    $customer = Personal::where('username', $request->phone_number)
        ->where('password', $request->password)
        ->where('status', 'SUBMITTED')
        ->first();
    
    if (is_null($customer)) {
      return back()->with('error', 'Login failed!');
    } else {
      Auth::login($customer, true);
      return back()->with('message', 'Login success!');
    }
  }

  public function home(Request $request) {
    $user = auth()->user();
    $orders = Order::where('created_by', $user->id)->get();

    return view('customer.home', ['orders' => $orders]);
  }
}