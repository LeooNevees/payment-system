<?php

namespace App\Repository;

use App\DTO\TransferDTO;
use App\Models\Transfer;
use Illuminate\Database\Eloquent\Collection;

class TransferRepository
{
    public static function findAll(): Collection
    {
        return Transfer::all();
    }

    public static function findBy(array $condition): Collection
    {
        return Transfer::where($condition)->get();
    }

    public static function create(TransferDTO $transfer): Transfer
    {
        return Transfer::create([
            'status' => $transfer->status,
        ]);
    }

    public static function update(int $id, array $params): bool
    {
        return Transfer::where('id', $id)
            ->update($params);
    }

    public static function destroy(int $id): bool
    {
        return Transfer::destroy($id);
    }
}
