<?php

namespace App\Helpers;

use App\Models\Log;

class CustomLogger
{
    public static function customLog($info, $message, $context)
    {

        // $contextJson = is_array($context) ? $context : json_decode($context, true);

        // Log::create([
        //     'info' => $info,
        //     'message' => $message,
        //     'context' => $context
        // ]);
        $contextJson = is_array($context) ? json_encode($context) : $context;

        $hash = md5($info . $message . $contextJson);

        $exists = Log::where('hash', $hash)->exists();

        if (!$exists) {
            Log::create([
                'info' => $info,
                'message' => $message,
                'context' => $contextJson,
                'hash' => $hash,
            ]);
        }
    }
}
