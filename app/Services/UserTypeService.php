<?php

namespace App\Services;

use App\DTO\UserTypeDTO;
use App\Repository\UserTypeRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class UserTypeService
{
    public function index(): array
    {
        $userTypes = UserTypeRepository::findAll();

        return [
            'error' => false,
            'data' => $userTypes->toArray(),
        ];
    }

    public function show(int $userTypeId): array
    {
        $userType = $this->getUserTypeById($userTypeId)[0];

        return [
            'error' => false,
            'data' => $userType->toArray(),
        ];
    }

    public function store(UserTypeDTO $userType): array
    {
        if (ValidateService::userTypeAlreadyRegistered($userType->description)) {
            throw new Exception("User Type already registered", 422);
        }

        $createdUserType = UserTypeRepository::create($userType);

        return [
            'error' => false,
            'message' => 'User Type created successfully',
            'data' => $createdUserType->toArray(),
        ];
    }

    public function update(array $newUserType, int $userTypeId): array
    {
        $oldUserType = $this->getUserTypeById($userTypeId)[0];

        $mergedUserType = array_merge($oldUserType->toArray(), $newUserType);
        $newUserType = UserTypeDTO::paramsToDto($mergedUserType);

        if ($newUserType->description != $oldUserType->description) {
            if (ValidateService::userTypeAlreadyRegistered($newUserType->description)) {
                throw new Exception("User Type already registered", 422);
            }
        }

        if (UserTypeRepository::update($newUserType, $userTypeId) === false) {
            throw new Exception("Error updating User Type. Please try again later", 500);
        };

        return [
            'error' => false,
            'message' => 'User Type updated successfully',
        ];
    }

    public function destroy(int $userTypeId): array
    {
        $this->getUserTypeById($userTypeId);

        if (UserTypeRepository::destroy($userTypeId) === false) {
            throw new Exception("Error deleting User Type. Please try again later", 500);
        }

        return [
            'error' => false,
            'message' => 'User Type deleted successfully',
        ];
    }

    private function getUserTypeById(int $userTypeId): Collection
    {
        $userType = UserTypeRepository::findBy([['id', $userTypeId]]);
        if ($userType === false) {
            throw new Exception("Error when searching User Type. Please try again later", 500);
        }

        if (!count($userType)) {
            throw new Exception("User Type not found", 404);
        }

        return $userType;
    }
}
