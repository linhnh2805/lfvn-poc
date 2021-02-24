<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResidenceImage extends Model {

  protected $table = 'residence_image';

  protected $fillable = [
    'residence_id', 'file_name', 'path', 'personal_id', 'order'
  ];

  public function residence() {
    return $this->belongsTo('App\Models\Residence');
  }
  public function person() {
    return $this->belongsTo('App\Model\Personal', 'personal_id', 'id');
  }
}