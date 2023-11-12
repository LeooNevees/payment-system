<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ExternalAuthorizationService
{
    public static function authorize(): bool
    {
        $response = Http::post(env('AUTHORIZATION_SERVICE_URL'));
        return $response->successful();
    }
}
