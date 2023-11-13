<?php

it('Deposit Api Index Success', function () {
    $response = $this->get('api/deposit', $this->getHeader());
    $response->assertStatus(200);

    $response = $response->json();
    $data = $response['data'][0];
    expect($response['error'])->toEqual(false);
    expect($data['automated_teller_machine_id'])->toEqual(1);
    expect($data['transfer_id'])->toEqual(1);
});

it('Deposit Api Show Success', function () {
    $response = $this->get('api/deposit/1', $this->getHeader());
    $response->assertStatus(200);

    $response = $response->json();
    $data = $response['data'][0];
    expect($response['error'])->toEqual(false);
    expect($data['automated_teller_machine_id'])->toEqual(1);
    expect($data['transfer_id'])->toEqual(1);
});

it('Deposit Api Show Not Found Error', function () {
    $response = $this->get('api/deposit/999', $this->getHeader());
    $response->assertStatus(404);

    $response = $response->json();
    expect($response['error'])->toEqual(true);
    expect($response['message'])->toEqual("Deposit not found");
});

it('Deposit Api Store Success', function () {
    $request = [
        'teller_machine_id' => 1,
        'bank_account_id' => 1,
        'value' => 1000,
    ];

    $response = $this->post('api/deposit', $request, $this->getHeader());
    $response->assertStatus(201);

    $response = $response->json();
    expect($response['error'])->toEqual(false);
    expect($response['message'])->toEqual("Starting Deposit");
});

it('Deposit Api Store Without Bank Account Id Error', function () {
    $request = [
        'teller_machine_id' => 1,
        'value' => 1000,
    ];

    $response = $this->post('api/deposit', $request, $this->getHeader());
    $response->assertStatus(422);

    $response = $response->json();
    expect($response['message'])->toEqual("The bank account id field is required.");
});

it('Deposit Api Store Without Value Error', function () {
    $request = [
        'teller_machine_id' => 1,
        'bank_account_id' => 1,
    ];

    $response = $this->post('api/deposit', $request, $this->getHeader());
    $response->assertStatus(422);

    $response = $response->json();
    expect($response['message'])->toEqual("The value field is required.");
});

it('Deposit Api Store Without Teller Machine Id Error', function () {
    $request = [
        'bank_account_id' => 1,
        'value' => 100,
    ];

    $response = $this->post('api/deposit', $request, $this->getHeader());
    $response->assertStatus(422);

    $response = $response->json();
    expect($response['message'])->toEqual("The teller machine id field is required.");
});

it('Deposit Api Store Without Data Error', function () {
    $response = $this->post('api/deposit', [], $this->getHeader());
    $response->assertStatus(422);

    $response = $response->json();
    expect($response['message'])->toEqual("The teller machine id field is required. (and 3 more errors)");
});