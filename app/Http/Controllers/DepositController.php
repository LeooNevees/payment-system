<?php

namespace App\Http\Controllers;

use App\DTO\DepositDTO;
use App\Http\Controllers\Base\Controller;
use App\Http\Requests\DepositRequest;
use App\Services\DepositService;
use Symfony\Component\HttpFoundation\Response;

class DepositController extends Controller
{
    public function __construct(
        private DepositService $service,
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

    public function show(int $depositId): Response
    {
        try {
            $user = $this->service->show($depositId);

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

    public function store(DepositRequest $request): Response
    {
        try {
            $createdDeposit = $this->service->store(DepositDTO::paramsToDto($request->all()));

            return response()->json($createdDeposit, Response::HTTP_CREATED);
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
