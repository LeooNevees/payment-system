<?php

namespace App\Services;

use App\DTO\DepositDTO;
use App\DTO\NotificationDTO;
use App\DTO\TransactionDTO;
use App\DTO\TransferDTO;
use App\Jobs\DepositJob;
use App\Jobs\NotificationJob;
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
    const DEPOSIT_ATTEMPTS = 2;
    
    public function index(): array
    {
        $users = DepositRepository::findAll();

        return [
            'error' => false,
            'data' => $users->toArray(),
        ];
    }

    public function show(int $depositId): array
    {
        if (!ValidateService::depositAlreadyRegistered($depositId)) {
            throw new Exception("Deposit not found", 404);
        }
        
        $user = DepositRepository::findBy([['id', $depositId]]);

        return [
            'error' => false,
            'data' => $user->toArray(),
        ];
    }

    public function store(DepositDTO $deposit): array
    {
        if (!ValidateService::automatedTellerMachineAlreadyRegistered($deposit->tellerMachineId)) {
            throw new Exception("Automated Teller Machine not found", 404);
        }

        $bankAccount = (new BankAccountService)->getBankAccountById($deposit->bankAccountId)[0];

        $createdTransfer = TransferRepository::create(TransferDTO::paramsToDto([
            'status' => Transfer::PENDING_STATUS,
        ]));

        DepositJob::dispatch($bankAccount, $deposit, $createdTransfer);

        return [
            'error' => false,
            'message' => 'Starting Deposit',
        ];
    }

    public function makeDeposit(BankAccount $bankAccount, DepositDTO $deposit, Transfer $createdTransfer): void
    {
        try {
            DB::transaction(function () use ($bankAccount, $deposit, $createdTransfer) {
                DepositRepository::create(DepositDTO::paramsToDto([
                    'teller_machine_id' => $deposit->tellerMachineId,
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
                if ($authorizedService === false) {
                    throw new Exception("Transfer Service not authorized", 400);
                }

                TransferRepository::update($createdTransfer->id, TransferDTO::paramsToDto([
                    'status' => Transfer::SUCCESS_STATUS,
                    'description' => 'FINISHED',
                ]));
            }, self::DEPOSIT_ATTEMPTS);

            NotificationJob::dispatch(NotificationDTO::paramsToDto([
                'message' => "Deposit of {$deposit->value} made successfully",
            ]));
        } catch (\Throwable $th) {
            TransferRepository::update($createdTransfer->id, TransferDTO::paramsToDto([
                'status' => Transfer::CANCELED_STATUS,
                'description' => $th->getMessage(),
            ]));
        }
    }
}
