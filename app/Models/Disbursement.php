<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disbursement extends Model {

  protected $table = 'disbursement';

  protected $fillable = [
    'personal_id', 'disbursement_method', 'account_owner',
    'account_number', 'bank_name', 'branch_name'
  ];

  public function person() {
    return $this->belongsTo('App\Models\Personal', 'personal_id', 'id');
  }
}