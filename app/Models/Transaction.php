<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'wallet_id',
        'related_wallet_id',
        'type',
        'amount'
    ];
}
