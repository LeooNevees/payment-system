<?php

use App\DTO\TransferDTO;
use App\Services\TransferService;

it('Transfer Api Index Success', function () {
    $response = $this->get('api/transfer', $this->getHeader());
    $response->assertStatus(200);

    $response = $response->json();
    $data = $response['data'][0];
    expect($response['error'])->toEqual(false);
    expect($data['id'])->toEqual(1);
    expect($data['status'])->toEqual('S');
    expect($data['description'])->toEqual(null);
});

it('Transfer Api Show Success', function () {
    $response = $this->get('api/transfer/1', $this->getHeader());
    $response->assertStatus(200);

    $response = $response->json();
    $data = $response['data'][0];
    expect($response['error'])->toEqual(false);
    expect($data['id'])->toEqual(1);
    expect($data['status'])->toEqual('S');
    expect($data['description'])->toEqual(null);
});

it('Transfer Api Show Not Found Error', function () {
    $response = $this->get('api/transfer/999', $this->getHeader());
    $response->assertStatus(404);

    $response = $response->json();
    expect($response['error'])->toEqual(true);
    expect($response['message'])->toEqual("Transfer not found");
});

it('Transfer Api Store Success', function () {
    $request = [
        'payer_account_id' => 1,
        'payee_account_id' => 2,
        'value' => 161.99
    ];
    $response = $this->post('api/transfer', $request, $this->getHeader());
    $response = $response->json();
    expect($response['error'])->toEqual(false);
    expect($response['message'])->toEqual("Starting Transfer");
});

it('Transfer Api Store Invalid User Type Shopkeeper Error', function () {
    $request = [
        'payer_account_id' => 2,
        'payee_account_id' => 1,
        'value' => 100
    ];
    $response = $this->post('api/transfer', $request, $this->getHeader());
    $response->assertStatus(422);

    $response = $response->json();
    expect($response['error'])->toEqual(true);
    expect($response['message'])->toEqual("Shopkeeper cannot make transfers");
});

it('Transfer Api Store Without Payer Id Error', function () {
    $request = [
        'payee_account_id' => 2,
        'value' => 100.00
    ];

    $response = $this->post('api/transfer', $request, $this->getHeader());
    $response->assertStatus(422);

    $response = $response->json();
    expect($response['message'])->toEqual("The payer account id field is required.");
});

it('Transfer Api Store Without Payee Id Error', function () {
    $request = [
        'payer_account_id' => 1,
        'value' => 100.00
    ];

    $response = $this->post('api/transfer', $request, $this->getHeader());
    $response->assertStatus(422);

    $response = $response->json();
    expect($response['message'])->toEqual("The payee account id field is required.");
});

it('Transfer Api Store Payer and Payee Accounts Are Equal Error', function () {
    $request = [
        'payer_account_id' => 1,
        'payee_account_id' => 1,
        'value' => 100.00
    ];

    $response = $this->post('api/transfer', $request, $this->getHeader());
    $response->assertStatus(422);

    $response = $response->json();
    expect($response['message'])->toEqual("Payer Account and Payee Account cannot be equal");
});

it('Transfer Api Store Without Value Error', function () {
    $request = [
        'payer_account_id' => 1,
        'payee_account_id' => 2,
    ];

    $response = $this->post('api/transfer', $request, $this->getHeader());
    $response->assertStatus(422);

    $response = $response->json();
    expect($response['message'])->toEqual("The value field is required.");
});

it('Transfer Api Store Without Data Error', function () {
    $response = $this->post('api/transfer', [], $this->getHeader());
    $response->assertStatus(422);

    $response = $response->json();
    expect($response['message'])->toEqual("The payer account id field is required. (and 3 more errors)");
});