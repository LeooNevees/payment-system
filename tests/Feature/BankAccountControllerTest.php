<?php

it('Bank Account Api Index Success', function () {
    $response = $this->get('api/bank-account', $this->getHeader());
    $response->assertStatus(200);

    $response = $response->json();
    $data = $response['data'][0];
    expect($response['error'])->toEqual(false);
    expect($data['id'])->toEqual(1);
    expect($data['user_id'])->toEqual(1);
    expect($data['agency_id'])->toEqual('1');
    expect($data['current_value'])->toEqual('2000');
    expect($data['status'])->toEqual('A');
});

it('Bank Account Api Show Success', function () {
    $response = $this->get('api/bank-account/1', $this->getHeader());
    $response->assertStatus(200);

    $response = $response->json();
    $data = $response['data'];
    expect($response['error'])->toEqual(false);
    expect($data['id'])->toEqual(1);
    expect($data['user_id'])->toEqual(1);
    expect($data['agency_id'])->toEqual('1');
    expect($data['current_value'])->toEqual('2000');
    expect($data['status'])->toEqual('A');
});

it('Bank Account Api Show Not Found Error', function () {
    $response = $this->get('api/bank-account/999', $this->getHeader());
    $response->assertStatus(404);

    $response = $response->json();
    expect($response['error'])->toEqual(true);
    expect($response['message'])->toEqual("Bank Account with ID 999 not found");
});

it('Bank Account Api Store Success', function () {
    $request = [
        'user_id' => 3,
        'agency_id' => 1,
    ];

    $response = $this->post('api/bank-account', $request, $this->getHeader());
    $response->assertStatus(201);

    $response = $response->json();
    $data = $response['data'];
    expect($response['error'])->toEqual(false);
    expect($data['user_id'])->toEqual($request['user_id']);
    expect($data['agency_id'])->toEqual($request['agency_id']);
});

it('Bank Account Api Store Without User Id Error', function () {
    $request = [
        'agency_id' => '0001',
    ];

    $response = $this->post('api/bank-account', $request, $this->getHeader());
    $response->assertStatus(422);

    $response = $response->json();
    expect($response['message'])->toEqual("The user id field is required. (and 1 more error)");
});

it('Bank Account Api Store Without Agency Id Error', function () {
    $request = [
        'user_id' => 1,
    ];

    $response = $this->post('api/bank-account', $request, $this->getHeader());
    $response->assertStatus(422);

    $response = $response->json();
    expect($response['message'])->toEqual("The agency id field is required.");
});

it('Bank Account Api Update Success', function () {
    $response = $this->patch('api/bank-account/1', [
        'status' => 'I',
    ], $this->getHeader());
    $response->assertStatus(200);

    $response = $response->json();
    expect($response['error'])->toEqual(false);
    expect($response['message'])->toEqual("Bank Account updated successfully");
});

it('Bank Account Api Update Not Found Error', function () {
    $response = $this->patch('api/bank-account/999', [
        'status' => 'I'
    ], $this->getHeader());
    $response->assertStatus(404);

    $response = $response->json();
    expect($response['error'])->toEqual(true);
    expect($response['message'])->toEqual("Bank Account with ID 999 not found");
});

it('Bank Account Api Delete Success', function () {
    $response = $this->delete('api/bank-account/3', [], $this->getHeader());
    $response->assertStatus(200);

    $response = $response->json();
    expect($response['error'])->toEqual(false);
    expect($response['message'])->toEqual("Bank Account deleted successfully");
});

it('Bank Account Api Delete With Transaction Registered Error', function () {
    $response = $this->delete('api/bank-account/2', [], $this->getHeader());
    $response->assertStatus(422);

    $response = $response->json();
    expect($response['error'])->toEqual(true);
    expect($response['message'])->toEqual("Bank Account already has transaction registered");
});

it('Bank Account Api Delete Not Found Error', function () {
    $response = $this->delete('api/bank-account/999', [], $this->getHeader());
    // $response->assertStatus(404);

    $response = $response->json();
    expect($response['error'])->toEqual(true);
    expect($response['message'])->toEqual("Bank Account not found");
});