<?php

use App\Models\User;
use Illuminate\Http\Response;

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create();

    $response = $this->post(route('auth.login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure(['access_token', 'token_type', 'expires_in']);
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post(route('auth.login'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('users can logout', function () {
    $user = User::factory()->create();

    $response1 = $this->postJson(route('auth.login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response2 = $this->withHeader('Authorization', 'Bearer ' . $response1->json('authorization.token'))
                    ->getJson(route('auth.me'));

    $response2
        ->assertStatus(Response::HTTP_OK);

    $response3 = $this->withHeader('Authorization', 'Bearer ' . $response1->json('authorization.token'))->post(route('auth.logout'));

    $response4 = $this->withHeader('Authorization', 'Bearer ' . $response1->json('authorization.token'))
                    ->getJson(route('auth.me'));

    $response4
        ->assertUnauthorized();
});
