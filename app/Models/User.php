<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;
use Illuminate\Database\Eloquent\Relations\hasOne;

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

  /**
  * Set the user/transactions relationship
  *
  * @return Illuminate\Database\Eloquent\Relations\hasMany
  */
  public function transactions() : hasMany
  {
      return $this->hasMany('App\Models\Transaction', 'foreign_key', 'payer_id');
  }

  /**
  * Set the user/wallet relationship
  *
  * @return Illuminate\Database\Eloquent\Relations\hasOne
  */
  public function wallet() : hasOne
  {
      return $this->hasOne('App\Models\Wallet');
  }
}
