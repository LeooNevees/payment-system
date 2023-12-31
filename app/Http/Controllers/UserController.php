<?php

namespace App\Http\Controllers;

use App\DTO\UserDTO;
use App\Http\Controllers\Base\Controller;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __construct(
        private UserService $service,
    ) {
    }

    public function index(): Response
    {
        try {
            $users = $this->service->index();

            return response()->json($users, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'error' => true,
                    'message' => $th->getMessage()
                ],
                $this->treatHttpCode($th->getCode())
            );
        }
    }

    public function show(int $userId): Response
    {
        try {
            $user = $this->service->show($userId);

            return response()->json($user, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'error' => true,
                    'message' => $th->getMessage()
                ],
                $this->treatHttpCode($th->getCode())
            );
        }
    }

    public function store(UserRequest $request): Response
    {
        try {
            $createdUser = $this->service->store(UserDTO::paramsToDto($request->all()));

            return response()->json($createdUser, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'error' => true,
                    'message' => $th->getMessage()
                ],
                $this->treatHttpCode($th->getCode())
            );
        }
    }

    public function update(UserRequest $request, string $userId): Response
    {
        try {
            $updatedUser = $this->service->update($request->all(), $userId);

            return response()->json($updatedUser, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'error' => true,
                    'message' => $th->getMessage()
                ],
                $this->treatHttpCode($th->getCode())
            );
        }
    }

    public function destroy(string $userId): Response
    {
        try {
            $deletedUser = $this->service->destroy($userId);

            return response()->json($deletedUser, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'error' => true,
                    'message' => $th->getMessage()
                ],
                $this->treatHttpCode($th->getCode())
            );
        }
    }
}
