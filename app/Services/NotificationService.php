<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NotificationService
{
    public static function send(): bool
    {
        $response = Http::post(env('NOTIFICATION_SERVICE_URL'));
        return false;
        return $response->successful();
    }
}
