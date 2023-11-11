<?php

namespace App\Interfaces;

interface DTOInterface
{
    public static function paramsToDto(array $params): self;
}
