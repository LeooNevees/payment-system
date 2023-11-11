<?php

namespace App\Http\Controllers\Base;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function treatHttpCode(mixed $code): int
    {
        if (is_int($code) && array_key_exists($code, Response::$statusTexts)) {
            return $code;
        }

        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }
}
