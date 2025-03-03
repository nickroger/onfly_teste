<?php

use App\Models\User;

use function Pest\Laravel\postJson;

it('user authenticated should can logout', function () {

    $user = User::factory()->create();
    $token = $user->createToken('device_test')->plainTextToken;
    postJson(route('auth.logout'), [], [
        'Authorization' => "Bearer {$token}"
    ])
        ->assertOk();
});
it('user authenticated should can not logout', function () {
    postJson(route('auth.logout'), [], [])
        ->assertJson([
            'message' => 'Unauthenticated.'
        ])
        ->assertStatus(401);
});
