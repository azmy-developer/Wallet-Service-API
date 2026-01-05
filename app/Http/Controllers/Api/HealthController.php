<?php

namespace App\Http\Controllers\Api;

class HealthController
{
    public function __invoke()
    {
        return ['status' => 'ok'];
    }
}
