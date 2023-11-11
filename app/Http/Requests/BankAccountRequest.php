<?php

namespace App\Http\Requests;

use App\Http\Requests\Base\Request;

class BankAccountRequest extends Request
{
    public function validatePost(): array
    {
        return [
            'user_id' => 'required|integer',
            'agency_id' => 'required|integer',
        ];
    }

    public function validatePatch(): array
    {
        return [
            'status' => 'required|string|max:1|in:A,I,a,i',
        ];
    }
}
