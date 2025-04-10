<?php

namespace App\Services;

use App\DTO\BankAccountDTO;
use App\DTO\NotificationDTO;
use App\DTO\TransactionDTO;
use App\DTO\TransferDTO;
use App\Jobs\NotificationJob;
use App\Jobs\TransferJob;
use App\Models\BankAccount;
use App\Models\Transaction;
use App\Models\Transfer;
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

    public function show(int $transferId): array
    {
        if (!ValidateService::transferAlreadyRegistered($transferId)) {
            throw new Exception("Transfer not found", 404);
        }

        $user = TransferRepository::findBy([['id', $transferId]]);

        return [
            'error' => false,
            'data' => $user->toArray(),
        ];
    }

    public function store(TransferDTO $transfer): array
    {
        dd('chegou aqui');
        $bankAccountService = new BankAccountService();
        $payerAccount = $bankAccountService->getBankAccountById(1)[0];
        $payeeAccount = $bankAccountService->getBankAccountById(2)[0];
        $payerUser = (new UserService())->getUserById($payerAccount->user_id)[0];

        if (ValidateService::userIsShopkeeper($payerUser)) {
            throw new Exception("Shopkeeper cannot make transfers", 422);
        }

        if (ValidateService::payerAndPayeeAreEqual($payerAccount, $payeeAccount)) {
            throw new Exception("Payer Account and Payee Account cannot be equal", 422);
        }

        $createdTransfer = TransferRepository::create($transfer);

        return [
            'error' => false,
            'message' => 'Starting Transfer',
        ];
    }

    public function makeTransfer(BankAccount $payerAccount, BankAccount $payeeAccount, TransferDTO $transfer, Transfer $createdTransfer): void
    {
        try {
            if (!ValidateService::bankAccountHasFunds($payerAccount, $transfer)) {
                throw new Exception("Insufficient funds in the Payer Account");
            }

            DB::transaction(function () use ($payerAccount, $payeeAccount, $transfer, $createdTransfer) {

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
                    throw new Exception("Transfer Service not authorized");
                }

                TransferRepository::update($createdTransfer->id, TransferDTO::paramsToDto([
                    'status' => Transfer::SUCCESS_STATUS,
                    'description' => 'FINISHED',
                ]));
            }, self::TRANSFER_ATTEMPTS);

            NotificationJob::dispatch(NotificationDTO::paramsToDto([
                'message' => "Transfer of {$transfer->value} made successfully",
            ]));
        } catch (\Throwable $th) {
            TransferRepository::update($createdTransfer->id, TransferDTO::paramsToDto([
                'status' => Transfer::CANCELED_STATUS,
                'description' => $th->getMessage(),
            ]));
        }
    }

    public function updateAccountCurrentValue(BankAccount $bankAccount, float $value, string $transactionType): void
    {
        $newValue = $transactionType == Transaction::DEBIT_TYPE
            ? $bankAccount->current_value + $value
            : $bankAccount->current_value - $value;

        BankAccountRepository::updateCurrentValue($bankAccount->id, BankAccountDTO::paramsToDto([
            'current_value' => $newValue,
        ]));
    }
}
