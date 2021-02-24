<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;

  protected $table = 'order';

  protected $fillable = [
    'personal_id', 'order_id', 'merchant', 'total', 'quantity'
  ];

  public function person() {
    return $this->belongsTo('App\Models\Personal', 'personal_id', 'id');
  }

  public function items() {
    return $this->hasMany('App\Models\OrderItem', 'item_id');
  }
}