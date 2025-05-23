<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait LogsExceptions
{
    protected function logException(\Exception $e, string $context = '')
    {
        Log::error("Error in {$context}:", [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ]);
    }
} 