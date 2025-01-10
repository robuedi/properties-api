<?php

use App\Models\User;
use Illuminate\Http\Response;

test('users can authenticate and get their profile data', function () {
    $user = User::factory()->create();

    $response_ = $this->post(route('auth.login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response = $this->withHeader('Authorization', 'Bearer ' . $response_->json('authorization.token'))
                    ->getJson(route('auth.me'));

    $response
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonPath('name', $user->name)
        ->assertJsonPath('email', $user->email);
});

test('users not authenticated can\'t get profile data', function () {
    $user = User::factory()->create();

    $response = $this->getJson(route('auth.me'));
    $response->assertUnauthorized();
});

test('token can be refreshed', function () {
    $user = User::factory()->create();

    $response1 = $this->postJson(route('auth.login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $oldToken = $response1->json('access_token');
    $response2 = $this->withHeader('Authorization', 'Bearer ' . $oldToken)
        ->postJson(route('auth.refresh'));

    $response2->assertStatus(Response::HTTP_OK)
                ->assertJsonStructure(['access_token', 'token_type', 'expires_in']);

    expect($oldToken)->not->toBe($response2->json('access_token'));
});
