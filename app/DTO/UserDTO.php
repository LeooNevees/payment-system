<?php

namespace App\DTO;

use App\DTO\Base\DTO;

class UserDTO extends DTO
{
    public function __construct(
        public string $name,
        public string $email,
        public int $userType,
        public int $document,
        public string $password,
        public string $status,
    ) {
    }

    public static function paramsToDto(array $params): self
    {
        return new self(
            name: isset($params['name']) ? mb_strtoupper(trim($params['name'])) : '',
            email: isset($params['email']) ? mb_strtoupper(trim($params['email'])) : '',
            userType: $params['user_type'] ?? 0,
            document: $params['document'] ?? 0,
            password: $params['password'] ?? '',
            status: isset($params['status']) ? mb_strtoupper(trim($params['status'])) : '',
        );    
    }
}
