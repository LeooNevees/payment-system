<?php

namespace App\Repository;

use App\DTO\BankAccountDTO;
use App\Models\BankAccount;
use Illuminate\Database\Eloquent\Collection;

class BankAccountRepository
{
    public static function findAll(): Collection
    {
        return BankAccount::all();
    }

    public static function findBy(array $condition): Collection
    {
        return BankAccount::where($condition)->get();
    }

    public static function create(BankAccountDTO $bankAccount): BankAccount
    {
        return BankAccount::create([
            'user_id' => $bankAccount->userId,
            'agency_id' => $bankAccount->agencyId,
        ]);
    }

    public static function updateStatus(int $id, BankAccountDTO $bankAccount): bool
    {
        return BankAccount::where('id', $id)
            ->update([
                'status' => $bankAccount->status,
            ]);
    }

    public static function updateCurrentValue(int $id, BankAccountDTO $bankAccount): bool
    {
        return BankAccount::where('id', $id)
            ->update([
                'current_value' => $bankAccount->currentValue,
            ]);
    }

    public static function destroy(int $id): bool
    {
        return BankAccount::destroy($id);
    }
}
