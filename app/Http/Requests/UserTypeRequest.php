<?php

namespace App\Http\Requests;

use App\Http\Requests\Base\Request;

class UserTypeRequest extends Request
{
    public function validatePost(): array
    {
        return [
            'description' => 'required|string|max:255',
        ];
    }

    public function validatePatch(): array
    {
        return [
            'description' => 'string|max:255',
            'status' => 'string|max:1|in:A,I,a,i'
        ];
    }
}
