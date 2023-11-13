<?php

it('UserType Api Index Success', function () {
    $response = $this->get('api/user-type', $this->getHeader());
    // $response->assertStatus(200);

    $response = $response->json();
    $data = $response['data'][0];
    expect($response['error'])->toEqual(false);
    expect($data['description'])->toEqual('PERSON');
    expect($data['status'])->toEqual('A');
});

it('UserType Api Show Success', function () {
    $response = $this->get('api/user-type/1', $this->getHeader());
    $response->assertStatus(200);

    $response = $response->json();
    $data = $response['data'];
    expect($response['error'])->toEqual(false);
    expect($data['description'])->toEqual('PERSON');
    expect($data['status'])->toEqual('A');
});

it('UserType Api Show Not Found Error', function () {
    $response = $this->get('api/user-type/999', $this->getHeader());
    $response->assertStatus(404);

    $response = $response->json();
    expect($response['error'])->toEqual(true);
    expect($response['message'])->toEqual("User Type not found");
});

it('UserType Api Store Success', function () {
    $request = [
        'description' => 'A new user type',
    ];

    $response = $this->post('api/user-type', $request, $this->getHeader());
    $response->assertStatus(201);

    $response = $response->json();
    $data = $response['data'];
    expect($response['error'])->toEqual(false);
    expect($response['message'])->toEqual("User Type created successfully");
    expect($data['description'])->toEqual(mb_strtoupper($request['description']));
});

it('UserType Api Store Without Data Error', function () {
    $response = $this->post('api/user-type', [], $this->getHeader());
    $response->assertStatus(422);

    $response = $response->json();
    expect($response['message'])->toEqual("The description field is required. (and 1 more error)");
});

it('UserType Api Update Success', function () {
    $request = [
        'description' => 'An updated user type',
    ];

    $response = $this->patch('api/user-type/3', $request, $this->getHeader());
    $response->assertStatus(200);

    $response = $response->json();
    expect($response['error'])->toEqual(false);
    expect($response['message'])->toEqual("User Type updated successfully");
});

it('UserType Api Update Not Found Error', function () {
    $request = [
        'description' => 'An updated user type',
    ];

    $response = $this->patch('api/user-type/999', $request, $this->getHeader());
    $response->assertStatus(404);

    $response = $response->json();
    expect($response['error'])->toEqual(true);
    expect($response['message'])->toEqual("User Type not found");
});

it('UserType Api Update Without Data Error', function () {
    $response = $this->patch('api/user-type/1', [], $this->getHeader());
    $response->assertStatus(422);

    $response = $response->json();
    expect($response['message'])->toEqual("At least one field must be entered");
});

it('UserType Api Destroy Success', function () {
    $response = $this->delete('api/user-type/3', [], $this->getHeader());
    $response->assertStatus(200);

    $response = $response->json();
    expect($response['error'])->toEqual(false);
    expect($response['message'])->toEqual("User Type deleted successfully");
});

it('UserType Api Destroy Not Found Error', function () {
    $response = $this->delete('api/user-type/999', [], $this->getHeader());
    $response->assertStatus(404);

    $response = $response->json();
    expect($response['error'])->toEqual(true);
    expect($response['message'])->toEqual("User Type not found");
});