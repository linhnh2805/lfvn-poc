<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;

  protected $table = 'order_item';

  protected $fillable = [
    'personal_id', 'order_id', 'item_id', 'item_name', 'quantity', 'price'
  ];

  public function person() {
    return $this->belongsTo('App\Models\Personal', 'personal_id', 'id');
  }

  public function order() {
    return $this->belongsTo('App\Models\Order');
  }
}