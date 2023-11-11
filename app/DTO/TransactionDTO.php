<?php

namespace App\DTO;

use App\DTO\Base\DTO;

class TransactionDTO extends DTO
{
    public function __construct(
        public int $bankAccountId,
        public int $transferId,
        public string $type,
        public float $value,
    ) {
    }

    public static function paramsToDto(array $params): self
    {
        return new self(
            bankAccountId: $params['bank_account_id'] ?? 0,
            transferId: $params['transfer_id'] ?? 0,
            type: isset($params['type']) ? mb_strtoupper($params['type']) : '',
            value: $params['value'] ?? 0,
        );    
    }
}
