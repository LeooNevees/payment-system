<?php

namespace App\DTO;

use App\DTO\Base\DTO;

class DepositDTO extends DTO
{
    public function __construct(
        public int $automatedTellerMachineId,
        public int $transferId,
        public int $bankAccountId,
        public float $value,
    ) {
    }

    public static function paramsToDto(array $params): self
    {
        return new self(
            automatedTellerMachineId: $params['automated_teller_machine_id'] ?? 0,
            transferId: $params['transfer_id'] ?? 0,
            bankAccountId: $params['bank_account_id'] ?? 0,
            value: $params['value'] ?? 0,
        );    
    }
}
