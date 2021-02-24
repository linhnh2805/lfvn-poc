<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model {
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;

  protected $table = 'contact';

  protected $fillable = [
    'personal_id', 'email', 'phone_number', 'second_phone_number',
    'available_time', 'first_reference_name', 'first_reference_national_id',
    'first_reference_relationship', 'first_reference_phone_number',
    'first_reference_same_address', 'second_reference_name',
    'second_reference_national_id', 'second_reference_relationship',
    'second_reference_phone_number', 'reserve_id',

    'otp', 'start_time', 'expire_time', 'status',
    'cic_credit_check', 'cic_credit_check_message'
  ];

  protected $casts = [
    'start_time' => 'datetime',
    'expire_time' => 'datetime'
  ];

  public function person() {
    return $this->belongsTo('App\Models\Personal', 'personal_id', 'id');
  }
}