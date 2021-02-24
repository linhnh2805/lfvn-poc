<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finance extends Model {

  protected $table = 'finance';

  protected $fillable = [
    'personal_id', 'check_income_agreement', 'income_type',
    'company_name', 'company_phone_number', 'company_address',
    'company_province', 'contract_length', 'job_type',
    'monthly_income', 'receive_type', 'start_job_date', 'monthly_cost',
    'dependent_person'
  ];

  public function person() {
    return $this->belongsTo('App\Models\Personal', 'personal_id', 'id');
  }
}