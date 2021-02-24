<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model {

  protected $table = 'payment';

  protected $fillable = [
    'personal_id', 'auto_charge_to_account', 'account_owner',
    'account_number', 'bank_name', 'branch_name',
    'payment_type', 'payment_cash_type'
  ];

  public function person() {
    return $this->belongsTo('App\Models\Personal', 'personal_id', 'id');
  }
}