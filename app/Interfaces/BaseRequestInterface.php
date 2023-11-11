<?php
namespace App\Interfaces;

interface BaseRequestInterface
{
    public function validatePost(): array;

    public function validatePatch(): array;
}