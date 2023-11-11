<?php

namespace Database\Seeders;

use App\DTO\UserTypeDTO;
use App\Repository\UserTypeRepository;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userTypes = [
            [
                'description' => 'Person',
                'status' => 'A',
            ],
            [
                'description' => 'Shopkeeper',
                'status' => 'A',
            ],
        ];

        foreach ($userTypes as $userType) {
            if(UserTypeRepository::findBy([['description', $userType['description']]])->first()) {
                continue;
            }

            UserTypeRepository::create(UserTypeDTO::paramsToDto($userType));
        }
    }
}
