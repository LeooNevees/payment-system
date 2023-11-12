<?php

namespace App\Services;

use App\DTO\NotificationDTO;
use Illuminate\Support\Facades\Http;

class NotificationService
{
    public static function send(NotificationDTO $notification): bool
    {
        $response = Http::post(env('NOTIFICATION_SERVICE_URL'));
        return false;
        return $response->successful();
    }
}
