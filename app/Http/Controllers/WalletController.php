<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Auth;

class WalletController extends Controller
{
  public function __construct(Wallet $wallet)
  {
      $this->wallet = $wallet;
  }
}
