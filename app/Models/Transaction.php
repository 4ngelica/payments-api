<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'payer_id',
        'payee_id',
        'value',
        'status'
    ];

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

    public function payer() {
        return $this->belongsTo('App\Models\User');
    }

    public function authorizePayerType($payer) {

        $payerType = User::where('id', $payer)->first()->getAttribute('type');

        if($payerType == 1){
            return false;
        }
        return true;
    }

    public function authorizeBalance($payer, $value) {

        $payerBalance = User::with('wallet')->where('id', $payer)->first()->getRelation('wallet')->getAttribute('balance');
        if($payerBalance >= $value ){
            return true;
        }
        return false;
    }

    public function decrementBalance($payer, $value) {
        $payerBalance = User::with('wallet')->where('id', $payer)->first()->getRelation('wallet');
        $payerBalance->setAttribute( 'balance', $payerBalance->getAttribute('balance') - floatval($value))->save();
    }
}
