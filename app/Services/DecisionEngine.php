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

class DecisionEngline {

  public function checkPerson($person) {
    $credit = 10000000;

    return $credit;
  }
}