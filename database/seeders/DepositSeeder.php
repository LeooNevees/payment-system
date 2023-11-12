<?php

namespace Database\Seeders;

use App\DTO\BankAccountDTO;
use App\DTO\DepositDTO;
use App\DTO\TransactionDTO;
use App\DTO\TransferDTO;
use App\Models\AutomatedTellerMachine;
use App\Models\Transaction;
use App\Models\Transfer;
use App\Repository\BankAccountRepository;
use App\Repository\DepositRepository;
use App\Repository\TransactionRepository;
use App\Repository\TransferRepository;
use Exception;
use Illuminate\Database\Seeder;

class DepositSeeder extends Seeder
{
    const DEPOSIT_VALUE = 2000;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DepositRepository::findAll()->first()) {
            return;
        }

        $bankAccount = BankAccountRepository::findAll()->first()->toArray(); 
        $automatedTellerMachine = AutomatedTellerMachine::first()->toArray();

        $transfer = TransferRepository::create(TransferDTO::paramsToDto([
            'status' => Transfer::SUCCESS_STATUS,
        ]));

        DepositRepository::create(DepositDTO::paramsToDto([
            'automated_teller_machine_id' => $automatedTellerMachine['id'],
            'transfer_id' => $transfer->id,
        ]));

        TransactionRepository::create(TransactionDTO::paramsToDto([
            'bank_account_id' => $bankAccount['id'],
            'transfer_id' => $transfer->id,
            'type' => Transaction::DEBIT_TYPE,
            'value' => self::DEPOSIT_VALUE,
        ]));

        BankAccountRepository::updateCurrentValue($bankAccount['id'], BankAccountDTO::paramsToDto([
            'current_value' => $bankAccount['current_value'] + self::DEPOSIT_VALUE,
        ]));
    }
}
