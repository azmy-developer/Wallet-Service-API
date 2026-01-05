<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransferRequest;
use App\Services\TransferService;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function store(TransferRequest $request, TransferService $service)
    {
        return $service->transfer(
            $request->from_wallet_id,
            $request->to_wallet_id,
            $request->amount,
            $request->header('Idempotency-Key')
        );
    }
}

