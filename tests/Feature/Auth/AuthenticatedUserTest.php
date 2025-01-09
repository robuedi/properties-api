<?php

use App\Models\User;
use Illuminate\Http\Response;

test('users can authenticate and get their profile data', function () {
    $user = User::factory()->create();

    $response_ = $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response = $this->getJson(route('authenticated.user'));

    $response
    ->assertStatus(Response::HTTP_OK)
    ->assertJsonPath('user.name', $user->name)
    ->assertJsonPath('user.email', $user->email);
});

test('users not authenticated can\'t get profile data', function () {
    $user = User::factory()->create();

    $response = $this->getJson(route('authenticated.user'));
    $response->assertUnauthorized();
});
