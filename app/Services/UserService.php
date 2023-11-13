<?php

namespace App\Services;

use App\DTO\UserDTO;
use App\Models\UserType;
use App\Repository\UserRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    public function index(): array
    {
        $users = UserRepository::findAll();

        return [
            'error' => false,
            'data' => $users->toArray(),
        ];
    }

    public function show(int $userId): array
    {
        $user = $this->getUserById($userId)[0];

        return [
            'error' => false,
            'data' => $user->toArray(),
        ];
    }

    public function store(UserDTO $user): array
    {
        if (ValidateService::emailAlreadyRegistered($user->email)) {
            throw new Exception("E-mail already registered", 422);
        }

        if (!ValidateService::userTypeIsValid($user->userType)) {
            throw new Exception("User Type not found", 404);
        }

        $this->validateDocument($user);

        $createdUser = UserRepository::create($user);

        return [
            'error' => false,
            'message' => 'User created successfully',
            'data' => $createdUser->toArray(),
        ];
    }

    public function update(array $newUser, int $userId): array
    {
        $oldUser = $this->getUserById($userId)[0];

        $mergedUser = array_merge($oldUser->makeVisible('password')->toArray(), $newUser);
        $newUser = UserDTO::paramsToDto($mergedUser);

        if ($newUser->email !== $oldUser->email) {
            if (ValidateService::emailAlreadyRegistered($newUser->email)) {
                throw new Exception("E-mail already registered", 422);
            }
        }

        if ($newUser->userType != $oldUser->userType) {
            if (!ValidateService::userTypeIsValid($newUser->userType)) {
                throw new Exception("User Type not found", 404);
            }

            if (!ValidateService::documentByUserType($newUser)) {
                throw new Exception("Invalid Document", 422);
            }
        }


        if ($newUser->document != $oldUser->document) {
            $this->validateDocument($newUser);
        }

        if (UserRepository::update($userId, $newUser) === false) {
            throw new Exception("Error updating User. Please try again later", 500);
        };

        return [
            'error' => false,
            'message' => 'User updated successfully',
        ];
    }

    public function destroy(int $userId): array
    {
        $this->getUserById($userId);

        if (UserRepository::destroy($userId) === false) {
            throw new Exception("Error deleting User. Please try again later", 500);
        }

        return [
            'error' => false,
            'message' => 'User deleted successfully',
        ];
    }

    public function getUserById(int $userId): Collection
    {
        $user = UserRepository::findBy([['id', $userId]]);
        if ($user === false) {
            throw new Exception("Error when searching User. Please try again later", 500);
        }

        if (!count($user)) {
            throw new Exception("User not found", 404);
        }

        return $user;
    }

    private function validateDocument(UserDTO $user): void
    {
        if (ValidateService::documentAlreadyRegistered($user->document)) {
            throw new Exception("Document already registered", 422);
        }

        if (!ValidateService::documentByUserType($user)) {
            throw new Exception("Invalid Document", 422);
        }
    }
}
