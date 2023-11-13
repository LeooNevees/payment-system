<?php

namespace Tests;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    private string $token;

    private function generateToken(): void
    {
        $user = User::find(1);
        $this->token = $user->createToken($user->email)->plainTextToken;
    }

    protected function getHeader(): array
    {
        if (empty($this->token)) {
            $this->generateToken();
        }
        
        return [
            'Accept' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest',
            'Authorization' => 'Bearer ' . $this->token
        ];    
    }

}
