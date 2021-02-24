<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Personal;
use Illuminate\Support\Facades\Log;
use App\Util\ConverterUtil;
use Storage;


class ReportController extends Controller {

  public function index(Request $request) {
    return view('vendor.backpack.custom.report');
  }

  public function export_personal(Request $request) {

    return 1;
  }
}