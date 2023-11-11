<?php

namespace App\Http\Controllers;

use App\DTO\BankAccountDTO;
use App\Http\Controllers\Base\Controller;
use App\Http\Requests\BankAccountRequest;
use App\Services\BankAccountService;
use Symfony\Component\HttpFoundation\Response;

class BankAccountController extends Controller
{
    public function __construct(
        private BankAccountService $service,
    ) {
    }

    public function index()
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

    public function show(string $id)
    {
        try {
            $user = $this->service->show($id);

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

    public function store(BankAccountRequest $request): Response
    {
        try {
            $createdBankAccount = $this->service->store(BankAccountDTO::paramsToDto($request->all()));

            return response()->json($createdBankAccount, Response::HTTP_CREATED);
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

    public function update(BankAccountRequest $request, string $id)
    {
        try {
            $updatedBankAccount = $this->service->update($request->all(), $id);

            return response()->json($updatedBankAccount, Response::HTTP_OK);
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
            $deletedBankAccount = $this->service->destroy($id);

            return response()->json($deletedBankAccount, Response::HTTP_OK);
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
