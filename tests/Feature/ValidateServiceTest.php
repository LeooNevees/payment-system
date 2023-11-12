<?php

use App\Models\UserType;
use App\Services\ValidateService;

it('Validate Document Already Registered Person Success', function () {
    $validation = ValidateService::documentAlreadyRegistered(11163122041);

    expect($validation)->toBeTrue();
});

it('Validate Document Already Registered Person Not Found Error', function () {
    $validation = ValidateService::documentAlreadyRegistered(11163122042);

    expect($validation)->toBeFalse();
});

it('Validate Document Already Registered Shopkeeper Success', function () {
    $validation = ValidateService::documentAlreadyRegistered(47106124000110);

    expect($validation)->toBeTrue();
});

it('Validate Document Already Registered Shopkeeper Not Found Error', function () {
    $validation = ValidateService::documentAlreadyRegistered(47106124000111);

    expect($validation)->toBeFalse();
});

it('Validate Email Already Registered Success', function () {
    $validation = ValidateService::emailAlreadyRegistered('TEST@EMAIL.COM');

    expect($validation)->toBeTrue();
});

it('Validate Email Already Registered Not Found Error', function () {
    $validation = ValidateService::emailAlreadyRegistered('TESTTT@EMAIL.COM');

    expect($validation)->toBeFalse();
});

it('Validate User Type Person Is Valid Success', function () {
    $validation = ValidateService::userTypeIsValid(UserType::PERSON);
    
    expect($validation)->toBeTrue();
});

it('Validate User Type Shopkeeper Is Valid Success', function () {
    $validation = ValidateService::userTypeIsValid(UserType::SHOPKEEPER);

    expect($validation)->toBeTrue();
});

it('Validate User Type Is Valid Not Found Error', function () {
    $validation = ValidateService::userTypeIsValid(999);

    expect($validation)->toBeFalse();
});

it('Validate User Type Already Registered Person Success', function () {
    $validation = ValidateService::userTypeAlreadyRegistered('PERSON');

    expect($validation)->toBeTrue();
});

it('Validate User Type Already Registered Shopkeeper Success', function () {
    $validation = ValidateService::userTypeAlreadyRegistered('SHOPKEEPER');

    expect($validation)->toBeTrue();
});

it('Validate User Type Already Registered Not Found Error', function () {
    $validation = ValidateService::userTypeAlreadyRegistered('TEST');

    expect($validation)->toBeFalse();
});

it('Validate User Already Registered Success', function () {
    $validation = ValidateService::userAlreadyRegistered(1);

    expect($validation)->toBeTrue();
});

it('Validate User Already Registered Not Found Error', function () {
    $validation = ValidateService::userAlreadyRegistered(999);

    expect($validation)->toBeFalse();
});

it('Validate Agency Already Registered Success', function () {
    $validation = ValidateService::agencyAlreadyRegistered(1);

    expect($validation)->toBeTrue();
});

it('Validate Agency Already Registered Not Found Error', function () {
    $validation = ValidateService::agencyAlreadyRegistered(999);

    expect($validation)->toBeFalse();
});

it('Validate User Already Has Account Registered Success', function () {
    $validation = ValidateService::userAlreadyHasAccountRegistered(1, 1);

    expect($validation)->toBeTrue();
});

it('Validate User Already Has Account Registered Not Found Error', function () {
    $validation = ValidateService::userAlreadyHasAccountRegistered(1, 999);

    expect($validation)->toBeFalse();
});

it('Validate Bank Account Already Registered Success', function () {
    $validation = ValidateService::bankAccountAlreadyRegistered(1);

    expect($validation)->toBeTrue();
});

it('Validate Bank Account Already Registered Not Found Error', function () {
    $validation = ValidateService::bankAccountAlreadyRegistered(999);

    expect($validation)->toBeFalse();
});

it('Validate Bank Account Already Has Transaction Registered Success', function () {
    $validation = ValidateService::bankAccountAlreadyHasTransactionRegistered(1);

    expect($validation)->toBeTrue();
});

it('Validate Bank Account Already Has Transaction Registered Not Found Error', function () {
    $validation = ValidateService::bankAccountAlreadyHasTransactionRegistered(999);

    expect($validation)->toBeFalse();
});

it('Validate Automated Teller Machine Already Registered Success', function () {
    $validation = ValidateService::automatedTellerMachineAlreadyRegistered(1);

    expect($validation)->toBeTrue();
});

it('Validate Automated Teller Machine Already Registered Not Found Error', function () {
    $validation = ValidateService::automatedTellerMachineAlreadyRegistered(999);

    expect($validation)->toBeFalse();
});




