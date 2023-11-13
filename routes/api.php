<?php

use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTypeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'user'], function () {
    Route::get('', [UserController::class, 'index']);
    Route::get('{id}', [UserController::class, 'show']);
    Route::post('', [UserController::class, 'store']);
    Route::patch('{id}', [UserController::class, 'update']);
    Route::delete('{id}', [UserController::class, 'destroy']);
});

Route::group(['prefix' => 'user-type'], function () {
    Route::get('', [UserTypeController::class, 'index']);
    Route::get('{id}', [UserTypeController::class, 'show']);
    Route::post('', [UserTypeController::class, 'store']);
    Route::patch('{id}', [UserTypeController::class, 'update']);
    Route::delete('{id}', [UserTypeController::class, 'destroy']);
});

Route::group(['prefix' => 'bank-account'], function () {
    Route::get('', [BankAccountController::class, 'index']);
    Route::get('{id}', [BankAccountController::class, 'show']);
    Route::get('transfers/{id}', [BankAccountController::class, 'showTransfers']);
    Route::post('', [BankAccountController::class, 'store']);
    Route::patch('{id}', [BankAccountController::class, 'update']);
    Route::delete('{id}', [BankAccountController::class, 'destroy']);
});

Route::group(['prefix' => 'transfer'], function () {
    Route::get('', [TransferController::class, 'index']);
    Route::get('{id}', [TransferController::class, 'show']);
    Route::post('', [TransferController::class, 'store']);
});

Route::group(['prefix' => 'deposit'], function () {
    Route::get('', [DepositController::class, 'index']);
    Route::get('{id}', [DepositController::class, 'show']);
    Route::post('', [DepositController::class, 'store']);
});