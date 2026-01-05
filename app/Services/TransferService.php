<?php

namespace App\Services;

use App\Enum\TransactionTypeEnum;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Repositories\IdempotencyRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\WalletRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class TransferService
{
    public function __construct(private IdempotencyRepository $idempotency) {}

    public function transfer(int $fromId, int $toId, int $amount, string $key)
    {
        if ($this->idempotency->exists($key)) {
            return response()->json([
                'message' => 'Request already processed (idempotent response)',
                'data'    => $this->idempotency->get($key),
            ], 200);
        }

        return DB::transaction(function () use ($fromId, $toId, $amount, $key) {

            $from = Wallet::lockForUpdate()->findOrFail($fromId);
            $to   = Wallet::lockForUpdate()->findOrFail($toId);

            if ($from->currency !== $to->currency) {
                abort(422, 'Currency mismatch');
            }

            if ($from->balance < $amount) {
                abort(422, 'Insufficient balance');
            }

            $from->decrement('balance', $amount);
            $to->increment('balance', $amount);

            $out = Transaction::create([
                'wallet_id' => $from->id,
                'related_wallet_id' => $to->id,
                'type' => TransactionTypeEnum::TRANSFER_OUT->value,
                'amount' => $amount
            ]);

            $in = Transaction::create([
                'wallet_id' => $to->id,
                'related_wallet_id' => $from->id,
                'type' => TransactionTypeEnum::TRANSFER_IN->value,
                'amount' => $amount
            ]);

            $response = [
                'from_transaction_id' => $out->id,
                'to_transaction_id' => $in->id,
            ];

            $this->idempotency->store($key, $response);
            return $response;
        });
    }
}


