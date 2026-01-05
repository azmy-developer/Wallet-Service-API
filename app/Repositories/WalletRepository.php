<?php

namespace App\Repositories;

use App\Models\Wallet;

/**
 * Class WalletRepository.
 */
class WalletRepository
{
    public function findForUpdate(int $id): Wallet
    {
        return Wallet::lockForUpdate()->findOrFail($id);
    }

    public function create(array $data): Wallet
    {
        return Wallet::create($data);
    }
}
