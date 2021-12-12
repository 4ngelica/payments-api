<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;


use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    const URL = 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6';
    var $errors = [];

    use HasFactory;
    protected $fillable = [
        'payer_id',
        'payee_id',
        'value',
        'status'
    ];

    /**
    * Returns an array with the request rules.
    *
    * @return array
    */
    public function rules() : array
    {
      return [
        'payer_id'=> 'required',
        'payee_id' => 'required',
        'value' => 'required'
      ];
    }

    /**
    * Returns an array with the feedback messages.
    *
    * @return array
    */
    public function feedback() : array
    {
      return [
        'required' => 'The :attribute field is required'
      ];
    }

    /**
    * Set the transaction/user relationship
    *
    * @return Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function payer()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
    * Validates a transaction request based
    * on its payer type, by returning
    * a boolean value
    *
    * @return bool
    */
    public function authorizePayerType($payerId) : bool
    {
        $payerType = User::where('id', $payerId)->first()->getAttribute('type');
        if($payerType == 1){
            $errors = ['teste'];
            return false;
        }
        return true;
    }

    /**
    * Validates a transaction request based
    * on payer's wallet balance, by returning
    * a boolean value
    *
    * @return bool
    */
    public function authorizeBalance($payerId, $value) : bool
    {
        $payerBalance = User::with('wallet')->where('id', $payerId)->first()->getRelation('wallet')->getAttribute('balance');
        if($payerBalance >= $value ){
            return true;
        }
        return false;
    }

    /**
    * Begin a transaction by decrementing
    * the value from payer's wallet
    * and incrementing it into payee's wallet
    *
    * @return void
    */
    public function beginTransaction($payerId, $payeeId, $value) : void
    {
        $payerBalance = User::with('wallet')->where('id', $payerId)->first()->getRelation('wallet');
        $payerBalance->setAttribute( 'balance', $payerBalance->getAttribute('balance') - floatval($value))->save();

        $payeeBalance = User::with('wallet')->where('id', $payeeId)->first()->getRelation('wallet');
        $payeeBalance->setAttribute( 'balance', $payeeBalance->getAttribute('balance') + floatval($value))->save();
    }

    /**
    * Revert a transaction by decrementing
    * the value from payee's wallet
    * and incrementing it into payers wallet
    *
    * @return void
    */
    public function revertTransaction($payerId, $payeeId, $value) : void
    {
        $payerBalance = User::with('wallet')->where('id', $payerId)->first()->getRelation('wallet');
        $payerBalance->setAttribute( 'balance', $payerBalance->getAttribute('balance') + floatval($value))->save();

        $payeeBalance = User::with('wallet')->where('id', $payeeId)->first()->getRelation('wallet');
        $payeeBalance->setAttribute( 'balance', $payeeBalance->getAttribute('balance') - floatval($value))->save();
    }

    /**
    * Validates a transaction request
    * by sending a GET request to
    * an external validation service
    * and sets a 'completed' transaction
    * status if is authorized
    *
    * @return bool
    */
    public function authorizeExternalService($pendingTransaction) : bool
    {
        $response = Http::get(self::URL);
        $response = collect(json_decode($response, true));
        $serviceResponse = Arr::get($response, 'message');

        if($serviceResponse == 'Autorizado'){
            $pendingTransaction->setAttribute( 'status', 'completed')->save();
            return true;
        }

        $pendingTransaction->setAttribute( 'status', 'canceled')->save();
        return false;
    }
}
