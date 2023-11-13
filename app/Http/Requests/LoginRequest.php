<?php

namespace App\Http\Requests;

use App\Http\Requests\Base\Request;

class LoginRequest extends Request
{
    public function validatePost(): array
    {
        return [
            'email' => 'required|email:rfc,dns',
            'password' => 'required|string|max:255',
        ];
    }

    public function validatePatch(): array
    {
        return [];
    }
}
