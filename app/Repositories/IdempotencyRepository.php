<?php

namespace App\Repositories;

use App\Models\IdempotencyKey;

/**
 * Class IdempotencyRepository.
 */
class IdempotencyRepository
{
    public function exists(string $key): bool
    {
        return IdempotencyKey::where('key', $key)->exists();
    }

    public function get(string $key): array
    {
        return IdempotencyKey::where('key', $key)->first()->response;
    }

    public function store(string $key, array $response): void
    {
        IdempotencyKey::create([
            'key' => $key,
            'response' => $response
        ]);
    }
}
