<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = ['owner_name', 'currency', 'balance'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
