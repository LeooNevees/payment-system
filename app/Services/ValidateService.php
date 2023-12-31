<?php

namespace App\Services;

use App\DTO\TransferDTO;
use App\DTO\UserDTO;
use App\Models\BankAccount;
use App\Models\User;
use App\Models\UserType;
use App\Repository\AgencyRepository;
use App\Repository\AutomatedTellerMachineRepository;
use App\Repository\BankAccountRepository;
use App\Repository\DepositRepository;
use App\Repository\TransactionRepository;
use App\Repository\TransferRepository;
use App\Repository\UserRepository;
use App\Repository\UserTypeRepository;
use Exception;

class ValidateService
{
    public static function documentAlreadyRegistered(int $document): bool
    {
        $retDocument = UserRepository::findBy([['document', $document]]);
        if (!count($retDocument)) {
            return false;
        }

        return true;
    }

    public static function personDocument(UserDTO $user): bool
    {
        if ($user->userType != UserType::PERSON) {
            throw new Exception("User type is not a Person");
        }

        if (strlen($user->document) != 11) {
            return false;
        }

        return true;
    }

    public static function shopkeeperDocument(UserDTO $user): bool
    {
        if ($user->userType != UserType::SHOPKEEPER) {
            throw new Exception("User type is not a Shopkeeper");
        }

        if (strlen($user->document) != 14) {
            return false;
        }

        return true;
    }

    public static function emailAlreadyRegistered(string $email): bool
    {
        $retEmail = UserRepository::findBy([['email', $email]]);
        if (!count($retEmail)) {
            return false;
        }

        return true;
    }

    public static function userTypeIsValid(int $userTypeId): bool
    {
        $retUserType = UserTypeRepository::findBy([['id', $userTypeId]]);
        if (!count($retUserType)) {
            return false;
        }

        return true;
    }

    public static function userTypeAlreadyRegistered(string $userTypeDescription): bool
    {
        $retUserType = UserTypeRepository::findBy([['description', $userTypeDescription]]);
        if (!count($retUserType)) {
            return false;
        }

        return true;
    }

    public static function documentByUserType(UserDTO $user): bool
    {
        return match ($user->userType) {
            UserType::PERSON => ValidateService::personDocument($user),
            UserType::SHOPKEEPER => ValidateService::shopkeeperDocument($user),
        };
    }

    public static function userAlreadyRegistered(int $userId): bool
    {
        $user = UserRepository::findBy([['id', $userId]]);
        if (!count($user)) {
            return false;
        }

        return true;
    }

    public static function agencyAlreadyRegistered(int $agencyId): bool
    {
        $agency = AgencyRepository::findBy([['id', $agencyId]]);
        if (!count($agency)) {
            return false;
        }

        return true;
    }

    public static function userAlreadyHasAccountRegistered(int $userId, int $agencyId): bool
    {
        $accountRegistered = BankAccountRepository::findBy([['user_id', $userId], ['agency_id', $agencyId]]);
        if (!count($accountRegistered)) {
            return false;
        }

        return true;
    }

    public static function transferAlreadyRegistered(int $transferId): bool
    {
        $transferRegistered = TransferRepository::findBy([['id', $transferId]]);
        if (!count($transferRegistered)) {
            return false;
        }

        return true;
    }

    public static function depositAlreadyRegistered(int $depositId): bool
    {
        $depositRegistered = DepositRepository::findBy([['id', $depositId]]);
        if (!count($depositRegistered)) {
            return false;
        }

        return true;
    }

    public static function bankAccountAlreadyRegistered(int $bankAccountId): bool
    {
        $bankAccount = BankAccountRepository::findBy([['id', $bankAccountId]]);
        if (!count($bankAccount)) {
            return false;
        }

        return true;
    }

    public static function bankAccountAlreadyHasTransactionRegistered(int $bankAccount): bool
    {
        $transaction = TransactionRepository::findBy([['bank_account_id', $bankAccount]]);
        if (!count($transaction)) {
            return false;
        }

        return true;
    }

    public static function automatedTellerMachineAlreadyRegistered(int $tellerMachineId): bool
    {
        $tellerMachine = AutomatedTellerMachineRepository::findBy([['id', $tellerMachineId]]);
        if (!count($tellerMachine)) {
            return false;
        }

        return true;
    }

    public static function bankAccountHasFunds(BankAccount $payerAccount, TransferDTO $transfer): bool
    {
        if ($payerAccount->current_value < $transfer->value) {
            return false;
        }

        return true;
    }

    public static function payerAndPayeeAreEqual(BankAccount $payerAccount, BankAccount $payeeAccount): bool
    {
        if ($payerAccount->id == $payeeAccount->id) {
            return true;
        }

        return false;
    }

    public static function userIsShopkeeper(User $user): bool
    {
        if ($user->user_type === UserType::SHOPKEEPER) {
            return true;
        }

        return false;
    }
}
