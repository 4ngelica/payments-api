<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Http;


use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    const URL = 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6';

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

    public function authorizeExternalService() {

        $response = Http::get(self::URL);
        if($response->ok()){
            return true;
        }
        return false;
    }

    public function revertTransaction($payer, $value){
        $payerBalance = User::with('wallet')->where('id', $payer)->first()->getRelation('wallet');
        $payerBalance->setAttribute( 'balance', $payerBalance->getAttribute('balance') + floatval($value))->save();
    }
}
