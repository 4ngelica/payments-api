<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('transaction', [TransactionController::class, 'index'])->name('index.transaction');
Route::get('transaction/{id}', [TransactionController::class, 'show'])->name('show.transaction');
Route::post('transaction', [TransactionController::class, 'store'])->name('store.transaction');
