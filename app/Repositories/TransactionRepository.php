<?php

namespace App\Repositories;

use App\Models\Transaction;

/**
 * Class TransactionRepository.
 */
class TransactionRepository
{
    public function create(array $data): Transaction
    {
        return Transaction::create($data);
    }
}
