<?php

namespace App\DTO;

use App\DTO\Base\DTO;

class UserTypeDTO extends DTO
{
    public function __construct(
        public string $description,
        public string $status,
    ) {
    }

    public static function paramsToDto(array $params): self
    {
        return new self(
            description: isset($params['description']) ? mb_strtoupper(trim($params['description'])) : null,
            status: isset($params['status']) ? mb_strtoupper(trim($params['status'])) : '',
        );    
    }
}
