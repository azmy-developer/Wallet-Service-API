<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdempotencyKey extends Model
{
    protected $fillable = ['key', 'response'];
    protected $casts = ['response' => 'array'];
}
