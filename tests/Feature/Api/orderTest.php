<?php

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

describe('Get order list', function () {
    test('create fake and get orders', function () {
        Order::factory()->count(10)->create();
        getJson(route('orders.index'), [])
            ->assertJsonStructure([])
            ->assertStatus(401);
    });
    test('get orders not values', function () {
        getJson(route('orders.index'), [])
            ->assertJson([
                'message' => 'Unauthenticated.'
            ])
            ->assertStatus(401);
    });
});
describe('Add order', function () {

    test('guest user cannot create a new order', function () {
        $data = Order::factory()->raw();

        postJson(route('orders.store'), $data)
            ->assertStatus(401);
        $this->assertDatabaseCount('orders', 0);
    });

    test('authenticated user can create a new order', function () {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $data = Order::factory()->raw();

        postJson(route('orders.store'), $data)
            ->assertStatus(302);
        $this->assertDatabaseCount('orders', 1);
    });

    test('error date weekend date going', function () {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $data = [
            'distiny' => "fake destiny",
            'going_date' => '2024-04-20',
            'back_date' => '2024-08-06',
            'id_user' => $user->id
        ];

        postJson(route('orders.store'), $data)
            ->assertJsonValidationErrors([
                'going_date' => "You can't choose a day that falls on a weekend"
            ])
            ->assertStatus(422);
    });

    test('error status required', function () {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $data = [
            'distiny' => "fake destiny",
            'going_date' => '2024-04-20',
            'back_date' => '2024-08-06',
            'id_user' => $user->id
        ];

        postJson(route('orders.store'), $data)
            ->assertJsonValidationErrors([
                'status' => trans('validation.required', ['attribute' => 'status'])
            ])
            ->assertStatus(422);
    });
});

describe('Delete Order', function () {
    test('guest user cannot delete a order', function () {
        $schedule = Order::factory()->create();
        deleteJson("orders/{$schedule->id}")
            ->assertStatus(401);
        $this->assertDatabaseCount('orders', 1);
    });
    test('authenticated user can delete a order', function () {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $order = Order::factory()->create();
        deleteJson("orders/{$order->id}")
            ->assertStatus(302);
        $this->assertDatabaseCount('orders', 0);
    });
});


describe('Edit order', function () {
    test('guest user cannot edit a order', function () {
        $order = Order::factory()->create();
        $data = Order::factory()->raw();
        putJson("orders/{$order->id}", $data)
            ->assertStatus(401);
        $this->assertdatabaseHas('orders', [
            'id' => $order->id,
            'destiny' => $order->destiny,
            'going_date' => $order->going_date,
            'back_date' => $order->back_date,
            'status' => $order->status,
            'id_user' => $order->id_user,
        ]);
    });
    test('authenticated user can edit a order', function () {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $order = Order::factory()->create();
        $data = Order::factory()->raw();
        putJson("orders/{$order->id}", $data)
            ->assertStatus(302);
    });
});
