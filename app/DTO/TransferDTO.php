<?php

namespace App\DTO;

use App\DTO\Base\DTO;
use App\Models\Transfer;

class TransferDTO extends DTO
{
    public function __construct(
        public int $payerAccountId,
        public int $payeeAccountId,
        public float $value,
        public string $status,
        public string $description,
    ) {
    }

    public static function paramsToDto(array $params): self
    {
        return new self(
            payerAccountId: $params['payer_account_id'] ?? 0,
            payeeAccountId: $params['payee_account_id'] ?? 0,
            value: $params['value'] ?? 0,
            status: isset($params['status']) ? mb_strtoupper($params['status']) : Transfer::PENDING_STATUS,
            description: isset($params['description']) ? mb_strtoupper($params['description']) : '',
        );    
    }
}
