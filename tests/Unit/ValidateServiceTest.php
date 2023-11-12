<?php

use App\DTO\BankAccountDTO;
use App\DTO\TransferDTO;
use App\DTO\UserDTO;
use App\Models\BankAccount;
use App\Models\User;
use App\Models\UserType;
use App\Services\ValidateService;

it('Validate Person Document Success', function () {
    $personDocument = ValidateService::personDocument(UserDTO::paramsToDto([
        'user_type' => UserType::PERSON,
        'document' => '11163122041',
    ]));

    expect($personDocument)->toBeTrue();
});

it('Validate Person Document With Invalid User Type Error', function () {
    expect(fn () => ValidateService::personDocument(UserDTO::paramsToDto([
        'user_type' => 999,
        'document' => '11163122041',
    ])))->toThrow(Exception::class, 'User type is not a Person');
});

it('Validate Person Document With Invalid Document Error', function () {
    $personDocument = ValidateService::personDocument(UserDTO::paramsToDto([
        'user_type' => UserType::PERSON,
        'document' => '1111631220411',
    ]));

    expect($personDocument)->toBeFalse();
});

it('Validate Shopkeeper Document Success', function () {
    $shopkeeperDocument = ValidateService::shopkeeperDocument(UserDTO::paramsToDto([
        'user_type' => UserType::SHOPKEEPER,
        'document' => '47106124000110',
    ]));

    expect($shopkeeperDocument)->toBeTrue();
});

it('Validate Shopkeeper Document With Invalid User Type Error', function () {
    expect(fn () => ValidateService::shopkeeperDocument(UserDTO::paramsToDto([
        'user_type' => 999,
        'document' => '47106124000110',
    ])))->toThrow(Exception::class, 'User type is not a Shopkeeper');
});

it('Validate Shopkeeper Document With Invalid Document Error', function () {
    $shopkeeperDocument = ValidateService::shopkeeperDocument(UserDTO::paramsToDto([
        'user_type' => UserType::SHOPKEEPER,
        'document' => '11111111111',
    ]));

    expect($shopkeeperDocument)->toBeFalse();
});

it('Validate Document By User Type Person Success', function () {
    $personDocument = ValidateService::documentByUserType(UserDTO::paramsToDto([
        'user_type' => UserType::PERSON,
        'document' => '11163122041',
    ]));

    expect($personDocument)->toBeTrue();
});

it('Validate Document By User Type Shopkeeper Success', function () {
    $shopkeeperDocument = ValidateService::documentByUserType(UserDTO::paramsToDto([
        'user_type' => UserType::SHOPKEEPER,
        'document' => '47106124000110',
    ]));

    expect($shopkeeperDocument)->toBeTrue();
});

it('Validate Bank Account Has Funds Success', function () {
    $bankAccount = new BankAccount;
    $bankAccount->current_value = 100;

    $bankAccountFunds = ValidateService::bankAccountHasFunds(
        $bankAccount,
        TransferDTO::paramsToDto([
            'value' => 50,
        ])
    );

    expect($bankAccountFunds)->toBeTrue();
});

it('Validate Bank Account Has Not Funds Error', function () {
    $bankAccount = new BankAccount;
    $bankAccount->current_value = 100;

    $bankAccountFunds = ValidateService::bankAccountHasFunds(
        $bankAccount,
        TransferDTO::paramsToDto([
            'value' => 150,
        ])
    );

    expect($bankAccountFunds)->toBeFalse();
});

it('Validate Payer And Payee Are Equal Success', function () {
    $payerAccount = new BankAccount;
    $payerAccount->id = 1;

    $payeeAccount = new BankAccount;
    $payeeAccount->id = 2;

    $validation = ValidateService::payerAndPayeeAreEqual($payerAccount, $payeeAccount);

    expect($validation)->toBeFalse();
});

it('Validate Payer And Payee Are Equal Error', function () {
    $payerAccount = new BankAccount;
    $payerAccount->id = 1;

    $payeeAccount = new BankAccount;
    $payeeAccount->id = 1;

    $validation = ValidateService::payerAndPayeeAreEqual($payerAccount, $payeeAccount);

    expect($validation)->toBeTrue();
});

it('Validate User Is Shopkeeper Success', function () {
    $user = new User();
    $user->user_type = UserType::SHOPKEEPER;

    $validation = ValidateService::userIsShopkeeper($user);

    expect($validation)->toBeTrue();
});

it('Validate User Is Shopkeeper Error', function () {
    $user = new User();
    $user->user_type = UserType::PERSON;

    $validation = ValidateService::userIsShopkeeper($user);

    expect($validation)->toBeFalse();
});
