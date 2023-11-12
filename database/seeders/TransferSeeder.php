<?php

namespace Database\Seeders;

use App\DTO\BankAccountDTO;
use App\DTO\TransactionDTO;
use App\DTO\TransferDTO;
use App\Models\Transaction;
use App\Models\Transfer;
use App\Repository\BankAccountRepository;
use App\Repository\TransactionRepository;
use App\Repository\TransferRepository;
use App\Services\TransferService;
use Illuminate\Database\Seeder;

class TransferSeeder extends Seeder
{
    const TRANSFER_VALUE = 500;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $person = BankAccountRepository::findBy([['user_id', 1]])->first();

        $shopkeeper = BankAccountRepository::findBy([['user_id', 2]])->first();
        
        if (count(TransferRepository::findAll()->toArray()) > 1) {
            return;
        }

        $transfer = TransferRepository::create(TransferDTO::paramsToDto([
            'status' => 'S'
        ]));


        TransactionRepository::create(TransactionDTO::paramsToDto([
            'bank_account_id' => $person['id'],
            'transfer_id' => $transfer['id'],
            'type' => Transaction::CREDIT_TYPE,
            'value' => self::TRANSFER_VALUE,
        ]));

        TransactionRepository::create(TransactionDTO::paramsToDto([
            'bank_account_id' => $shopkeeper['id'],
            'transfer_id' => $transfer['id'],
            'type' => Transaction::DEBIT_TYPE,
            'value' => self::TRANSFER_VALUE,
        ]));
    }
}
