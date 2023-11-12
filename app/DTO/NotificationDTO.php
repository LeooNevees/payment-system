<?php

namespace App\DTO;

use App\DTO\Base\DTO;

class NotificationDTO extends DTO
{
    public function __construct(
        public int $phone,
        public string $message,
    ) {
    }

    public static function paramsToDto(array $params): self
    {
        return new self(
            phone: $params['phone'] ?? 0,
            message: $params['message'] ?? '',
        );    
    }
}
