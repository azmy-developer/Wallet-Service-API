<?php

use App\Http\Controllers\Api\HealthController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\TransferController;
use App\Http\Controllers\Api\WalletController;
use Illuminate\Support\Facades\Route;

Route::get('/health', HealthController::class);

Route::post('/wallets', [WalletController::class, 'store']);
Route::get('/wallets', [WalletController::class, 'index']);
Route::get('/wallets/{id}', [WalletController::class, 'show']);
Route::get('/wallets/{id}/balance', [WalletController::class, 'balance']);

Route::post('/wallets/{id}/deposit', [TransactionController::class, 'deposit']);
Route::post('/wallets/{id}/withdraw', [TransactionController::class, 'withdraw']);
Route::get('/wallets/{id}/transactions', [TransactionController::class, 'history']);

Route::post('/transfers', [TransferController::class, 'store']);

