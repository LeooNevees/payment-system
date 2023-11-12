<?php

namespace App\Http\Requests;

use App\Http\Requests\Base\Request;

class TransferRequest extends Request
{
    public function validatePost(): array
    {
        return [
            'payer_account_id' => 'required|integer',
            'payee_account_id' => 'required|integer',
            'value' => 'required|numeric',
        ];
    }

    public function validatePatch(): array
    {
        return [];
    }
}
