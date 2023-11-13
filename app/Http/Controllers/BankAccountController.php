<?php

namespace App\Http\Controllers;

use App\DTO\BankAccountDTO;
use App\Http\Controllers\Base\Controller;
use App\Http\Requests\BankAccountRequest;
use App\Services\BankAccountService;
use App\Services\ValidateService;
use Exception;
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

    public function show(int $accountId)
    {
        try {
            $user = $this->service->show($accountId);

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

    public function showTransfers(int $accountId)
    {
        try {
            if (!ValidateService::bankAccountAlreadyRegistered($accountId)) {
                throw new Exception("Bank Account not found", 404);
            }
            
            $transfers = $this->service->showTransfers($accountId);

            return response()->json($transfers, Response::HTTP_OK);
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

    public function update(BankAccountRequest $request, string $accountId)
    {
        try {
            $updatedBankAccount = $this->service->update($request->all(), $accountId);

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

    public function destroy(string $accountId)
    {
        try {
            $deletedBankAccount = $this->service->destroy($accountId);

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
