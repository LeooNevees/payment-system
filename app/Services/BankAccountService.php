<?php

namespace App\Services;

use App\DTO\BankAccountDTO;
use App\Repository\BankAccountRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class BankAccountService
{
    public function index(): array
    {
        $users = BankAccountRepository::findAll();

        return [
            'error' => false,
            'data' => $users->toArray(),
        ];
    }

    public function show(int $id): array
    {
        $user = $this->getBankAccountById($id)[0];

        return [
            'error' => false,
            'data' => $user->toArray(),
        ];
    }

    public function store(BankAccountDTO $bankAccount): array
    {
        if (!ValidateService::userAlreadyRegistered($bankAccount->userId)) {
            throw new Exception("User not found", 404);
        }

        if (!ValidateService::agencyAlreadyRegistered($bankAccount->agencyId)) {
            throw new Exception("Agency not found", 404);
        }

        if (ValidateService::userAlreadyHasAccountRegistered($bankAccount->userId, $bankAccount->agencyId)) {
            throw new Exception("User already has an account registered in this agency", 422);
        }

        $createdBankAccount = BankAccountRepository::create($bankAccount);

        return [
            'error' => false,
            'message' => 'Bank Account created successfully',
            'data' => $createdBankAccount->toArray(),
        ];
    }

    public function update(array $newBankAccount, int $id): array
    {
        $oldBankAccount = $this->getBankAccountById($id)[0];

        $mergedBankAccount = array_merge($oldBankAccount->toArray(), $newBankAccount);
        $newBankAccount = BankAccountDTO::paramsToDto($mergedBankAccount);

        if (BankAccountRepository::updateStatus($id, $newBankAccount) === false) {
            throw new Exception("Error updating Bank Account. Please try again later", 500);
        };

        return [
            'error' => false,
            'message' => 'Bank Account updated successfully',
        ];
    }

    public function destroy(int $id): array
    {
        if (!ValidateService::bankAccountAlreadyRegistered($id)) {
            throw new Exception("Bank Account not found", 404);
        }

        if (ValidateService::bankAccountAlreadyHasTransactionRegistered($id)) {
            throw new Exception("Bank Account already has transaction registered", 422);
        }

        if (BankAccountRepository::destroy($id) === false) {
            throw new Exception("Error deleting Bank Account. Please try again later", 500);
        }

        return [
            'error' => false,
            'message' => 'Bank Account deleted successfully',
        ];
    }

    public function getBankAccountById(int $id): Collection
    {
        $bankAccount = BankAccountRepository::findBy([['id', $id]]);
        if (!count($bankAccount)) {
            throw new Exception("Bank Account with ID {$id} not found", 404);
        }

        return $bankAccount;
    }
}
