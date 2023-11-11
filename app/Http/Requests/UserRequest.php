<?php

namespace App\Http\Requests;

use App\Http\Requests\Base\Request;

class UserRequest extends Request
{
    public function validatePost(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns',
            'user_type' => 'required|integer',
            'document' => 'required|numeric|min_digits:11|max_digits:14',
            'password' => 'required|string|max:255',
        ];
    }

    public function validatePatch(): array
    {
        return [
            'name' => 'string|max:255',
            'email' => 'email:rfc,dns',
            'user_type' => 'integer',
            'document' => 'string|min:10|max:14',
            'password' => 'string|max:255',
            'status' => 'max:1|in:A,I,a,i'
        ];
    }
}
