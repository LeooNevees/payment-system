<?php

namespace App\Repository;

use App\DTO\TransactionDTO;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;

class TransactionRepository
{
    public static function findAll(): Collection
    {
        return Transaction::all();
    }

    public static function findBy(array $condition): Collection
    {
        return Transaction::where($condition)->get();
    }

    public static function create(TransactionDTO $transaction): Transaction
    {
        return Transaction::create([
            'bank_account_id' => $transaction->bankAccountId,
            'transfer_id' => $transaction->transferId,
            'type' => $transaction->type,
            'value' => $transaction->value,
        ]);
    }

    public static function update(int $id, array $params): bool
    {
        return Transaction::where('id', $id)
            ->update($params);
    }

    public static function destroy(int $id): bool
    {
        return Transaction::destroy($id);
    }
}
