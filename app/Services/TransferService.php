<?php

namespace App\Services;

use App\DTO\BankAccountDTO;
use App\DTO\TransactionDTO;
use App\DTO\TransferDTO;
use App\Models\BankAccount;
use App\Models\Transaction;
use App\Repository\BankAccountRepository;
use App\Repository\TransactionRepository;
use App\Repository\TransferRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class TransferService
{
    const TRANSFER_ATTEMPTS = 2;

    public function index(): array
    {
        $users = TransferRepository::findAll();

        return [
            'error' => false,
            'data' => $users->toArray(),
        ];
    }

    public function show(int $id): array
    {
        $user = TransferRepository::findBy([['id', $id]]);

        return [
            'error' => false,
            'data' => $user->toArray(),
        ];
    }

    public function store(TransferDTO $transfer): array
    {
        $bankAccountService = new BankAccountService();
        $payerAccount = $bankAccountService->getBankAccountById($transfer->payerAccountId)[0];
        $payeeAccount = $bankAccountService->getBankAccountById($transfer->payeeAccountId)[0];
        $payerUser = (new UserService())->getUserById($payerAccount->user_id)[0];

        if (ValidateService::userIsShopkeeper($payerUser)) {
            throw new Exception("Shopkeeper cannot make transfers", 422);
        }

        if (!ValidateService::bankAccountHasFunds($payerAccount, $transfer)) {
            throw new Exception("Insufficient funds in the Payer Account", 422);
        }

        if (ValidateService::payerAndPayeeAreEqual($payerAccount, $payeeAccount)) {
            throw new Exception("Payer Account and Payee Account cannot be equal", 422);
        }

        $this->makeTransfer($payerAccount, $payeeAccount, $transfer);

        return [
            'error' => false,
            'message' => 'Transfer completed successfully',
        ];
    }

    private function makeTransfer(BankAccount $payerAccount, BankAccount $payeeAccount, TransferDTO $transfer): void
    {
        DB::transaction(function () use ($payerAccount, $payeeAccount, $transfer) {
            $createdTransfer = TransferRepository::create($transfer);

            TransactionRepository::create(TransactionDTO::paramsToDto([
                'bank_account_id' => $transfer->payerAccountId,
                'transfer_id' => $createdTransfer->id,
                'type' => Transaction::CREDIT_TYPE,
                'value' => $transfer->value,
            ]));

            TransactionRepository::create(TransactionDTO::paramsToDto([
                'bank_account_id' => $transfer->payeeAccountId,
                'transfer_id' => $createdTransfer->id,
                'type' => Transaction::DEBIT_TYPE,
                'value' => $transfer->value,
            ]));

            $this->updateAccountCurrentValue($payerAccount, $transfer->value, Transaction::CREDIT_TYPE);

            $this->updateAccountCurrentValue($payeeAccount, $transfer->value, Transaction::DEBIT_TYPE);

            $authorizedService = (new ExternalAuthorizationService())->authorize();
            if (!$authorizedService) {
                throw new Exception("Transfer Service not authorized", 400);
            }
        }, self::TRANSFER_ATTEMPTS);

        // DISPACHAR O SMS PRA FILA 
    }

    public function updateAccountCurrentValue(BankAccount $bankAccount, float $value, string $transactionType): void
    {
        $newValue = $transactionType == Transaction::DEBIT_TYPE 
            ? $bankAccount->current_value + $value 
            : $bankAccount->current_value - $value ;

        BankAccountRepository::updateCurrentValue($bankAccount->id, BankAccountDTO::paramsToDto([
            'current_value' => $newValue,
        ]));
    }
}
