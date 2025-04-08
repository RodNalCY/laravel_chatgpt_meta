<?php
namespace App\Helpers;

use App\Models\Log;

class CustomLogger
{
    public static function customLog($info, $message, $context = [])
    {

        $contextJson = !empty($context) ? json_encode($context) : null;

        Log::create([
            'info' => $info,
            'message' => $message,
            'context' => $contextJson
        ]);
    }
}
