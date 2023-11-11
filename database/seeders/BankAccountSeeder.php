<?php

namespace Database\Seeders;

use App\DTO\BankAccountDTO;
use App\Models\Agency;
use App\Models\User;
use App\Repository\BankAccountRepository;
use App\Repository\UserRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agency = Agency::first()->toArray();
        $person = UserRepository::findBy([['document', '11163122041']])->first();
        $shopkeeper = UserRepository::findBy([['document', '47106124000110']])->first();

        BankAccountRepository::create(BankAccountDTO::paramsToDto([
            'user_id' => $person['id'],
            'agency_id' => $agency['id'],
        ]));

        BankAccountRepository::create(BankAccountDTO::paramsToDto([
            'user_id' => $shopkeeper['id'],
            'agency_id' => $agency['id'],
        ]));
    }
}
