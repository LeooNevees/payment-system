<?php

namespace App\Repository;

use App\DTO\UserDTO;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    public static function findAll(): Collection
    {
        return User::all();
    }

    public static function findBy(array $condition): Collection
    {
        return User::where($condition)->get();
    }

    public static function create(UserDTO $user): User
    {
        return User::create([
            'name' => $user->name,
            'email' => $user->email,
            'user_type' => $user->userType,
            'document' => $user->document,
            'password' => $user->password,
        ]);
    }

    public static function update(int $id, UserDTO $newUser): bool
    {
        return User::where('id', $id)
            ->update([
                'name' => $newUser->name,
                'email' => $newUser->email,
                'user_type' => $newUser->userType,
                'document' => $newUser->document,
                'password' => $newUser->password,
            ]);
    }

    public static function destroy(int $id): bool
    {
        return User::destroy($id);
    }
}
