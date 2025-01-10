<?php

use App\Models\User;

test('new users can register', function () {
    $response = $this->post(route('auth.register'), [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertNoContent();

    // the correct data
    $this->assertDatabaseHas((new User)->getTable(), [
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);
});
