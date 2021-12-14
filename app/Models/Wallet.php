<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Auth;


class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
      'user_id',
      'balance'
    ];

    /**
    * Set the wallet/user relationship
    *
    * @return Illuminate\Database\Eloquent\Relations\belongsTo
    */
    public function user() : belongsTo
    {
        return $this->belongsTo('App\Models\User');
    }
}
