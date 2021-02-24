<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Residence extends Model {

  protected $table = 'residence';

  protected $fillable = [
    'person_id', 'current_address', 'current_province', 'residence_same_as_address',
    'residence_address', 'residence_province', 'residence_start_date',
    'residence_status'
  ];

  public function person() {
    return $this->belongsTo('App\Models\Personal', 'personal_id', 'id');
  }
}