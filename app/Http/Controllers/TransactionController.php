<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function __construct(Transaction $transaction)
    {
      $this->transaction = $transaction;
    }

    public function store(Request $request) {

        $transacao = $this->transaction->create($request->validate($this->transaction->rules(), $this->transaction->feedback()));
        return response()->json($transacao);
    }

    public function index() {
        $transaction = $this->transaction->all();
        return response()->json($transaction);
    }

    public function show($id) {
        $transaction = $this->transaction->find($id);
        return response()->json($transaction);
    }
}
