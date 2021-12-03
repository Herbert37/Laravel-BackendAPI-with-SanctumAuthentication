<?php

namespace App\Http\Controllers\Utils;
use Illuminate\Support\Facades\Log;

class LogManager
{
    public function error($message, $ref = ''){
        Log::error($message ." ". $ref);
    }

    public function info($message, $ref = ''){
        Log::info($message." ". $ref);
    }
}