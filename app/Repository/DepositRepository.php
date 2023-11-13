<?php

namespace App\Repository;

use App\DTO\DepositDTO;
use App\Models\Deposit;
use Illuminate\Database\Eloquent\Collection;

class DepositRepository
{
    public static function findAll(): Collection
    {
        return Deposit::all();
    }

    public static function findBy(array $condition): Collection
    {
        return Deposit::where($condition)->get();
    }

    public static function create(DepositDTO $deposit): Deposit
    {
        return Deposit::create([
            'automated_teller_machine_id' => $deposit->tellerMachineId,
            'transfer_id' => $deposit->transferId,
        ]);
    }
}
