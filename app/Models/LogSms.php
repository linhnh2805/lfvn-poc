<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogSms extends Model {
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;

  protected $table = 'log_sms';

  protected $fillable = [
    'start_time', 'session_id', 'url', 'request_type', 'phone', 'otp', 'request_body', 'status_code', 'response_body', 
    'message_id', 'partner_id', 'tel_co', 'error', 'error_description'
  ];

  protected $casts = [
    'start_time' => 'datetime'
  ];
}