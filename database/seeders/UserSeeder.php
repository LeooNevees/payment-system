<?php

namespace Database\Seeders;

use App\DTO\UserDTO;
use App\Repository\UserRepository;
use App\Repository\UserTypeRepository;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (UserRepository::findBy([['email', 'test@email.com']])->first()) {
            return;
        }

        $userType = UserTypeRepository::findBy([['description', 'PERSON']])->first();

        $shopkeeperType = UserTypeRepository::findBy([['description', 'SHOPKEEPER']])->first();

        $users = [
            [
                'name' => 'Test',
                'email' => 'test@email.com',
                'user_type' => $userType['id'],
                'document' => '11163122041',
                'password' => '123456789',
            ],
            [
                'name' => 'Test 2',
                'email' => 'test2@email.com',
                'user_type' => $shopkeeperType['id'],
                'document' => '47106124000110',
                'password' => '123456789',
            ],
            [
                'name' => 'Test 3',
                'email' => 'test3@email.com',
                'user_type' => $shopkeeperType['id'],
                'document' => '47106124000111',
                'password' => '123456789',
            ]
        ];

        foreach ($users as $user) {
            UserRepository::create(UserDTO::paramsToDto($user));
        }
    }
}
