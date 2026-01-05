<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MoneyRequest;
use App\Models\Transaction;
use App\Services\WalletService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function deposit(MoneyRequest $request, $id, WalletService $service)
    {
        return $service->deposit($id, $request->amount, $request->header('Idempotency-Key'));
    }

    public function withdraw(MoneyRequest $request, $id, WalletService $service)
    {
        return $service->withdraw($id, $request->amount, $request->header('Idempotency-Key'));
    }

    public function history(Request $request, $id)
    {
        return Transaction::where('wallet_id', $id)
            ->when($request->type, fn($q) => $q->where('type', $request->type))
            ->when($request->from_date, fn($q) => $q->whereDate('created_at', '>=', $request->from_date))
            ->when($request->to_date, fn($q) => $q->whereDate('created_at', '<=', $request->to_date))
            ->orderBy('created_at')
            ->paginate(10);
    }
}


