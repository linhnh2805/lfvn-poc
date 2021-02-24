<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class LogCic extends Model {
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;

  protected $table = 'log_cic';

  protected $guarded = [
    'uuid', 'request_type', 'url', 'personal_id', 'contact_id', 'status_code',
    'error_code', 'error_message', 'data', 'start_time', 'request_body', 'response_body'
  ];

  protected $casts = [
    'start_time' => 'datetime'
  ];
}