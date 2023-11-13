<?php

namespace App\DTO;

use App\DTO\Base\DTO;

class DepositDTO extends DTO
{
    public function __construct(
        public int $tellerMachineId,
        public int $transferId,
        public int $bankAccountId,
        public float $value,
    ) {
    }

    public static function paramsToDto(array $params): self
    {
        return new self(
            tellerMachineId: $params['teller_machine_id'] ?? 0,
            transferId: $params['transfer_id'] ?? 0,
            bankAccountId: $params['bank_account_id'] ?? 0,
            value: $params['value'] ?? 0,
        );    
    }
}
