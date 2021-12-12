<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;

class TransactionController extends Controller
{
    public function __construct(Transaction $transaction)
    {
      $this->transaction = $transaction;
    }

    public function store(Request $request) {

        $pendingTransaction = $request->validate($this->transaction->rules(), $this->transaction->feedback());

        if($this->transaction->authorizePayerType($request->payer_id)){
            $this->transaction->create($pendingTransaction);
            return response()->json($pendingTransaction);
        }

        return response()->json(['Error' => 'Non authorized']);
    }

    public function index() {
        $transaction = $this->transaction->all();
        return response()->json($transaction);
    }

    public function show($id) {
        $transaction = $this->transaction->find($id);
        return response()->json($transaction);
    }

    // public function handleRequest($payer, $payee) {
    //
    //   return response()->json('blz');
    // }
}
