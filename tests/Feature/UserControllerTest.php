<?php

it('User Api Index Success', function () {
    $response = $this->get('api/user', $this->getHeader());
    $response->assertStatus(200);

    $response = $response->json();
    $data = $response['data'][0];
    expect($response['error'])->toEqual(false);
    expect($data['id'])->toEqual(1);
    expect($data['name'])->toEqual('TEST');
    expect($data['email'])->toEqual('TEST@EMAIL.COM');
    expect($data['user_type'])->toEqual('1');
    expect($data['document'])->toEqual('11163122041');
    expect($data['status'])->toEqual('A');
});

it('User Api Show Success', function () {
    $response = $this->get('api/user/1', $this->getHeader());
    $response->assertStatus(200);

    $response = $response->json();
    $data = $response['data'];
    expect($response['error'])->toEqual(false);
    expect($data['id'])->toEqual(1);
    expect($data['name'])->toEqual('TEST');
    expect($data['email'])->toEqual('TEST@EMAIL.COM');
    expect($data['user_type'])->toEqual('1');
    expect($data['document'])->toEqual('11163122041');
    expect($data['status'])->toEqual('A');
});

it('User Api Show Not Found Error', function () {
    $response = $this->get('api/user/999', $this->getHeader());
    $response->assertStatus(404);


    $response = $response->json();
    expect($response['error'])->toEqual(true);
    expect($response['message'])->toEqual("User not found");
});

it('User Api Store Success', function () {
    $request = [
        'name' => 'TEST',
        'email' => 'new_test@email.com',
        'user_type' => '1',
        'document' => '37645812044',
        'password' => 'Test@123'
    ];

    $response = $this->post('api/user', $request, $this->getHeader());
    $response->assertStatus(201);

    $response = $response->json();
    $data = $response['data'];
    expect($response['error'])->toEqual(false);
    expect($data['name'])->toEqual($request['name']);
    expect($data['email'])->toEqual(mb_strtoupper($request['email']));
    expect($data['user_type'])->toEqual($request['user_type']);
    expect($data['document'])->toEqual($request['document']);
});

it('User Api Store With User Already Registered Error', function () {
    $request = [
        'name' => 'TEST',
        'email' => 'new_test@email.com',
        'user_type' => '1',
        'document' => '37645812044',
        'password' => 'Test@123'
    ];

    $response = $this->post('api/user', $request, $this->getHeader());
    $response->assertStatus(422);

    $response = $response->json();
    expect($response['error'])->toEqual(true);
    expect($response['message'])->toEqual("E-mail already registered");
});

it('User Api Store Without Name Error', function () {
    $request = [
        'email' => 'new_test@email.com',
        'user_type' => '1',
        'document' => '37645812044',
        'password' => 'Test@123'
    ];

    $response = $this->post('api/user', $request, $this->getHeader());
    $response->assertStatus(422);

    $response = $response->json();
    expect($response['message'])->toEqual("The name field is required.");
});

it('User Api Store Without Email Error', function () {
    $request = [
        'name' => 'TEST',
        'user_type' => '1',
        'document' => '37645812044',
        'password' => 'Test@123'
    ];

    $response = $this->post('api/user', $request, $this->getHeader());
    $response->assertStatus(422);

    $response = $response->json();
    expect($response['message'])->toEqual("The email field is required.");
});

it('User Api Store Without User Type Error', function () {
    $request = [
        'name' => 'TEST',
        'email' => 'new_test@email.com',
        'document' => '37645812044',
        'password' => 'Test@123'
    ];

    $response = $this->post('api/user', $request, $this->getHeader());
    $response->assertStatus(422);

    $response = $response->json();
    expect($response['message'])->toEqual("The user type field is required.");
});

it('User Api Store Without Document Error', function () {
    $request = [
        'name' => 'TEST',
        'email' => 'new_test@email.com',
        'user_type' => '1',
        'password' => 'Test@123'
    ];

    $response = $this->post('api/user', $request, $this->getHeader());
    $response->assertStatus(422);

    $response = $response->json();
    expect($response['message'])->toEqual("The document field is required.");
});

it('User Api Store Without Password Error', function () {
    $request = [
        'name' => 'TEST',
        'email' => 'new_test@email.com',
        'user_type' => '1',
        'document' => '37645812044',
    ];

    $response = $this->post('api/user', $request, $this->getHeader());
    $response->assertStatus(422);

    $response = $response->json();
    expect($response['message'])->toEqual("The password field is required.");
});

it('User Api Store Without Data Error', function () {
    $response = $this->post('api/user', [], $this->getHeader());
    $response->assertStatus(422);

    $response = $response->json();
    expect($response['message'])->toEqual("The name field is required. (and 5 more errors)");
});

it('User Api Update Name Success', function () {
    $response = $this->patch('api/user/1', [
        'name' => 'TEST',
    ], $this->getHeader());
    $response->assertStatus(200);

    $response = $response->json();
    expect($response['error'])->toEqual(false);
    expect($response['message'])->toEqual("User updated successfully");
});

it('User Api Update Email Success', function () {
    $response = $this->patch('api/user/2', [
        'email' => 'newTest2@email.com',
    ], $this->getHeader());
    $response->assertStatus(200);

    $response = $response->json();
    expect($response['error'])->toEqual(false);
    expect($response['message'])->toEqual("User updated successfully");
});

it('User Api Update Email Already Registered Error', function () {
    $response = $this->patch('api/user/3', [
        'email' => 'test@email.com',
    ], $this->getHeader());
    $response->assertStatus(422);

    $response = $response->json();
    expect($response['error'])->toEqual(true);
    expect($response['message'])->toEqual("E-mail already registered");
});

it('User Api Update User Type Success', function () {
    $response = $this->patch('api/user/3', [
        'user_type' => '2',
        'document' => '25699377000101'
    ], $this->getHeader());
    $response->assertStatus(200);

    $response = $response->json();
    expect($response['error'])->toEqual(false);
    expect($response['message'])->toEqual("User updated successfully");
});

it('User Api Update User Type With Invalid Document Error', function () {
    $response = $this->patch('api/user/3', [
        'user_type' => '1',
        'document' => '25699377000101'
    ], $this->getHeader());
    $response->assertStatus(422);

    $response = $response->json();
    expect($response['error'])->toEqual(true);
    expect($response['message'])->toEqual("Invalid Document");
});

it('User Api Update Document Success', function () {
    $response = $this->patch('api/user/3', [
        'document' => '25699377000221'
    ], $this->getHeader());
    $response->assertStatus(200);

    $response = $response->json();
    expect($response['error'])->toEqual(false);
    expect($response['message'])->toEqual("User updated successfully");
});

it('User Api Delete Success', function () {
    $response = $this->delete('api/user/3', [], $this->getHeader());
    $response->assertStatus(200);

    $response = $response->json();
    expect($response['error'])->toEqual(false);
    expect($response['message'])->toEqual("User deleted successfully");
});

it('User Api Delete Not Found Error', function () {
    $response = $this->delete('api/user/999', [], $this->getHeader());
    $response->assertStatus(404);

    $response = $response->json();
    expect($response['error'])->toEqual(true);
    expect($response['message'])->toEqual("User not found");
});
