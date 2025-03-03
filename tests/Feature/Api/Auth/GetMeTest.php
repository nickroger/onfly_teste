<?php

use App\Models\User;

use function Pest\Laravel\getJson;

test('unauthenticated user cannot get me', function () {
    getJson(route('auth.me'), [])
        ->assertJson([
            'message' => 'Unauthenticated.'
        ])
        ->assertStatus(401);
});

test('shoould return user with our data', function () {
    $user = User::factory()->create();
    $token = $user->createToken('device_test')->plainTextToken;
    getJson(route('auth.me'), [
        'Authorization' => "Bearer {$token}"
    ])
        ->assertJsonStructure([
            'me' => [
                'id',
                'name',
                'email',
                'email_verified_at',
                'created_at',
                'updated_at',
            ]
        ])
        ->assertOk();
});
