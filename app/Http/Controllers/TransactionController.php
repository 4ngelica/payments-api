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

    public function store(Request $request){
      return response()->json($request->all());
    }

}
