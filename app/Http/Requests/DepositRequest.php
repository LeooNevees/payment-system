<?php

namespace App\Http\Requests;

use App\Http\Requests\Base\Request;

class DepositRequest extends Request
{
    public function validatePost(): array
    {
        return [
            'teller_machine_id' => 'required|integer',
            'bank_account_id' => 'required|integer',
            'value' => 'required|numeric',
        ];
    }

    public function validatePatch(): array
    {
        return [];
    }
    
}
