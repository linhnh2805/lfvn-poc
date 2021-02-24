<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purpose extends Model {

  protected $table = 'purpose';

  protected $fillable = [
    'personal_id', 'lending_amount', 'lending_length', 'lending_purpose',
    'payment_date', 'secure_lending_info', 'loan_insurance'
  ];

  public function person() {
    return $this->belongsTo('App\Models\Personal', 'personal_id', 'id');
  }
}