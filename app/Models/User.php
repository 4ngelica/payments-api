<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'email',
    'password',
    'identity',
    'type'
  ];

  public function transactions() {
      return $this->hasMany('App\Models\Transaction', 'foreign_key', 'payer_id');
  }

  public function wallet() {
      return $this->hasOne('App\Models\Wallet');
  }
}
