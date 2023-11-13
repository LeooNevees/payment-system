<?php

namespace App\Repository;

use App\DTO\UserTypeDTO;
use App\Models\UserType;
use Illuminate\Database\Eloquent\Collection;

class UserTypeRepository
{
    public static function findAll(): Collection
    {
        return UserType::all();
    }

    public static function findBy(array $condition): Collection
    {
        return UserType::where($condition)->get();
    }

    public static function create(UserTypeDTO $userType): UserType
    {
        return UserType::create([
            'description' => $userType->description,
        ]);
    }

    public static function update(UserTypeDTO $newUserType, int $userTypeId): bool
    {
        return UserType::where('id', $userTypeId)
            ->update([
                'description' => $newUserType->description,
                'status' => $newUserType->status,
            ]);
    }

    public static function destroy(int $userTypeId): bool
    {
        return UserType::destroy($userTypeId);
    }
}
