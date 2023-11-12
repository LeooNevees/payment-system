<?php

namespace App\Services;

use App\DTO\DepositDTO;
use App\DTO\TransactionDTO;
use App\DTO\TransferDTO;
use App\Models\BankAccount;
use App\Models\Transaction;
use App\Models\Transfer;
use App\Repository\DepositRepository;
use App\Repository\TransactionRepository;
use App\Repository\TransferRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class DepositService
{
    public function index(): array
    {
        $users = DepositRepository::findAll();

        return [
            'error' => false,
            'data' => $users->toArray(),
        ];
    }

    public function show(int $id): array
    {
        $user = DepositRepository::findBy([['id', $id]]);

        return [
            'error' => false,
            'data' => $user->toArray(),
        ];
    }

    public function store(DepositDTO $deposit): array
    {
        if (!ValidateService::automatedTellerMachineAlreadyRegistered($deposit->automatedTellerMachineId)) {
            throw new Exception("Automated Teller Machine not found", 404);
        }

        $bankAccount = (new BankAccountService)->getBankAccountById($deposit->bankAccountId)[0];

        $this->makeDeposit($bankAccount, $deposit);

        return [
            'error' => false,
            'message' => 'Deposit created successfully',
        ];
    }

    private function makeDeposit(BankAccount $bankAccount, DepositDTO $deposit): void
    {
        DB::transaction(function () use ($bankAccount, $deposit) {
            $createdTransfer = TransferRepository::create(TransferDTO::paramsToDto([
                'status' => Transfer::SUCCESS_STATUS,
            ]));

            DepositRepository::create(DepositDTO::paramsToDto([
                'automated_teller_machine_id' => $deposit->automatedTellerMachineId,
                'transfer_id' => $createdTransfer->id,
            ]));

            TransactionRepository::create(TransactionDTO::paramsToDto([
                'bank_account_id' => $deposit->bankAccountId,
                'transfer_id' => $createdTransfer->id,
                'type' => Transaction::DEBIT_TYPE,
                'value' => $deposit->value,
            ]));

            (new TransferService)->updateAccountCurrentValue($bankAccount, $deposit->value, Transaction::DEBIT_TYPE);

            $authorizedService = (new ExternalAuthorizationService())->authorize();
            if (!$authorizedService) {
                throw new Exception("Transfer Service not authorized", 400);
            }
        });

        // DISPACHAR O SMS PRA FILA 
    }
}
