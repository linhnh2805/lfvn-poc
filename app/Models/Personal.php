<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
# Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class Personal extends Authenticatable {
  use Notifiable, CrudTrait;

  protected $table = 'personal';

  // protected $fillable = ['full_name', 'gender', 'dob', 'job',
  //   'education', 'job_position', 'martial_status', 'national_id',
  //   'issue_date', 'issue_at', 'old_national_id', 'passport',

  //   'address', 'birthday', 'ward', 'district', 'province', 'ethnicity', 'expiry',
  //   'home_town', 'last_name', 'first_name', 'religion', 'sex',
  //   //'logiccheck', 'logicmessage', 'face_score',
  //   //'cic_fraud_check', 'cic_fraud_check_message', 'device_token',

  //   'is_lend', 'status', 'agreement_usage_information', 'agreement_receive_advertise'
  //   ];

  // Backpack
  protected $guarded = [
    'password', 'logiccheck', 'logicmessage', 'face_score',
    'cic_fraud_check', 'cic_fraud_check_message', 'device_token', 'cic_credit_check'
  ];

  /*
  |--------------------------------------------------------------------------
  | RELATIONS
  |--------------------------------------------------------------------------
  */
  public function images() {
    return $this->hasMany('App\Models\ResidenceImage');
  }
  public function contacts() {
    return $this->hasMany('App\Models\Contact');
  }
  public function finances() {
    return $this->hasMany('App\Models\Finance');
  }
  public function residences() {
    return $this->hasMany('App\Models\Residencee');
  }
  public function purposes() {
    return $this->hasMany('App\Models\Purpose');
  }
  public function disbursements() {
    return $this->hasMany('App\Models\Disbursement');
  }
  public function orders() {
    return $this->hasMany('App\Models\Order');
  }
}