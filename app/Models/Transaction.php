<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = ['payer_id', 'payee_id', 'value', 'status'];

    public function rules() {
      return [
        'payer_id'=> 'required',
        'payee_id' => 'required',
        'value' => 'required'
      ];
    }

    public function feedback() {
      return [
        'required' => 'The :attribute field is required'
      ];
    }
}
