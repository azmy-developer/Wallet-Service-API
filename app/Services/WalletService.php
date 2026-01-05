<?php

namespace App\Services;

use App\Enum\TransactionTypeEnum;
use App\Repositories\IdempotencyRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\WalletRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class WalletService
{
    public function __construct(
        private WalletRepository $wallets,
        private TransactionRepository $transactions,
        private IdempotencyRepository $idempotency
    ) {}

    public function deposit(int $walletId, int $amount, string $key)
    {
        if ($this->idempotency->exists($key)) {
            return $this->idempotency->get($key);
        }

        return DB::transaction(function () use ($walletId, $amount, $key) {
            $wallet = $this->wallets->findForUpdate($walletId);
            $wallet->increment('balance', $amount);

            $tx = $this->transactions->create([
                'wallet_id' => $wallet->id,
                'type' => TransactionTypeEnum::DEPOSIT->value,
                'amount' => $amount
            ]);

            $this->idempotency->store($key, $tx->toArray());
            return $tx;
        });
    }

    public function withdraw(int $walletId, int $amount, string $key)
    {
        if ($this->idempotency->exists($key)) {
            return $this->idempotency->get($key);
        }

        return DB::transaction(function () use ($walletId, $amount, $key) {
            $wallet = $this->wallets->findForUpdate($walletId);

            if ($wallet->balance < $amount) {
//                abort(422, 'Insufficient balance');
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient balance',
                    'data' => null
                ], 400);
            }

            $wallet->decrement('balance', $amount);

            $tx = $this->transactions->create([
                'wallet_id' => $wallet->id,
                'type' => TransactionTypeEnum::WITHDRAW->value,
                'amount' => $amount
            ]);

            $this->idempotency->store($key, $tx->toArray());
            return $tx;
        });
    }
}

