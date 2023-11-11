<?php

namespace App\DTO;

use App\DTO\Base\DTO;

class TransferDTO extends DTO
{
    public function __construct(
        public string $status,
    ) {
    }

    public static function paramsToDto(array $params): self
    {
        return new self(
            status: isset($params['status']) ? mb_strtoupper($params['status']) : '',
        );    
    }
}
