<?php

namespace App\Http\Controllers;

use App\DTO\TransferDTO;
use App\Http\Controllers\Base\Controller;
use App\Http\Requests\TransferRequest;
use App\Services\TransferService;
use Symfony\Component\HttpFoundation\Response;

class TransferController extends Controller
{
    public function __construct(
        private TransferService $service,
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

    public function show(int $transferId)
    {
        try {
            $user = $this->service->show($transferId);

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

    public function store(TransferRequest $request): Response
    {
        try {
            $createdTransfer = $this->service->store(TransferDTO::paramsToDto($request->all()));

            return response()->json($createdTransfer, Response::HTTP_CREATED);
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
