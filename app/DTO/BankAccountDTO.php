<?php

namespace App\DTO;

use App\DTO\Base\DTO;

class BankAccountDTO extends DTO
{
    public function __construct(
        public int $userId,
        public int $agencyId,
        public float $currentValue,
        public string $status,
    ) {
    }

    public static function paramsToDto(array $params): self
    {
        return new self(
            userId: $params['user_id'] ?? 0,
            agencyId: $params['agency_id'] ?? 0,
            currentValue: $params['current_value'] ?? 0,
            status: isset($params['status']) ? mb_strtoupper($params['status']) : '',
        );    
    }
}
