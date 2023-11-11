<?php

namespace App\Http\Controllers;

use App\DTO\UserTypeDTO;
use App\Http\Controllers\Base\Controller;
use App\Http\Requests\UserTypeRequest;
use App\Services\UserTypeService;
use Symfony\Component\HttpFoundation\Response;

class UserTypeController extends Controller
{
    public function __construct(
        private UserTypeService $service
    ) {
    }

    public function index()
    {
        try {
            $userTypes = $this->service->index();

            return response()->json($userTypes, Response::HTTP_OK);
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

    public function show(string $id)
    {
        try {
            $userType = $this->service->show($id);

            return response()->json($userType, Response::HTTP_OK);
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

    public function store(UserTypeRequest $request): Response
    {
        try {
            $createdUserType = $this->service->store(UserTypeDTO::paramsToDto($request->all()));

            return response()->json($createdUserType, Response::HTTP_CREATED);
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

    public function update(UserTypeRequest $request, string $id)
    {
        try {
            $updatedUserType = $this->service->update($request->all(), $id);

            return response()->json($updatedUserType, Response::HTTP_OK);
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

    public function destroy(string $id)
    {
        try {
            $deletedUser = $this->service->destroy($id);

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
