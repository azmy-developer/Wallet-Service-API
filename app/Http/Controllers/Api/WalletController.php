<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateWalletRequest;
use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function store(CreateWalletRequest $request)
    {
        return Wallet::create($request->validated());
    }

    public function index(Request $request)
    {
        return Wallet::query()
            ->when($request->owner, fn($q) => $q->where('owner_name', $request->owner))
            ->when($request->currency, fn($q) => $q->where('currency', $request->currency))
            ->get();
    }

    public function show($id)
    {
        return Wallet::findOrFail($id);
    }

    public function balance($id)
    {
        return ['balance' => Wallet::findOrFail($id)->balance];
    }
}

