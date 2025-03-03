<?php

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

describe('Get schedule list', function () {
    test('create fake and get schedules', function () {
        Schedule::factory()->count(10)->create();
        getJson(route('schedules.index'), [])
            ->assertJsonStructure([])
            ->assertStatus(401);
    });
    test('get schedules not values', function () {
        getJson(route('schedules.index'), [])
            ->assertJson([
                'message' => 'Unauthenticated.'
            ])
            ->assertStatus(401);
    });
});
describe('Add Schedule', function () {

    test('guest user cannot create a new schedule', function () {
        $data = Schedule::factory()->raw();

        postJson(route('schedules.store'), $data)
            ->assertStatus(401);
        $this->assertDatabaseCount('schedules', 0);
    });

    test('authenticated user can create a new schedule', function () {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $data = Schedule::factory()->raw();

        postJson(route('schedules.store'), $data)
            ->assertStatus(302);
        $this->assertDatabaseCount('schedules', 1);
    });

    test('error date weekend date start', function () {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $data = [
            'title' => "fake title",
            'description' => 'fake description',
            'start_date' => '2024-04-20',
            'deadline_date' => '2024-08-06',
            'conclusion_date' => '2024-08-07',
            'id_user' => $user->id
        ];

        postJson(route('schedules.store'), $data)
            ->assertJsonValidationErrors([
                'start_date' => "You can't choose a day that falls on a weekend"
            ])
            ->assertStatus(422);
    });

    test('error date weekend date deadline', function () {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $data = [
            'title' => "fake title",
            'description' => 'fake description',
            'start_date' => '2024-04-05',
            'deadline_date' => '2024-04-20',
            'conclusion_date' => '2024-04-07',
            'status' => 'Open',
            'id_user' => $user->id
        ];

        postJson(route('schedules.store'), $data)
            ->assertJsonValidationErrors([
                'deadline_date' => "You can't choose a day that falls on a weekend"
            ])
            ->assertStatus(422);
    });

    test('error date weekend date conclusion', function () {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $data = [
            'title' => "fake title",
            'description' => 'fake description',
            'start_date' => '2024-04-05',
            'deadline_date' => '2024-04-06',
            'conclusion_date' => '2024-04-20',
            'status' => 'Open',
            'id_user' => $user->id
        ];

        postJson(route('schedules.store'), $data)
            ->assertJsonValidationErrors([
                'conclusion_date' => "You can't choose a day that falls on a weekend"
            ])
            ->assertStatus(422);
    });

    test('error status required', function () {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $data = [
            'title' => "fake title",
            'description' => 'fake description',
            'start_date' => '2024-04-05',
            'deadline_date' => '2024-08-06',
            'conclusion_date' => '2024-08-20',
            'id_user' => $user->id
        ];

        postJson(route('schedules.store'), $data)
            ->assertJsonValidationErrors([
                'status' => trans('validation.required', ['attribute' => 'status'])
            ])
            ->assertStatus(422);
    });
});

describe('Delete Schedule', function () {
    test('guest user cannot delete a schedule', function () {
        $schedule = Schedule::factory()->create();
        deleteJson("schedules/{$schedule->id}")
            ->assertStatus(401);
        $this->assertDatabaseCount('schedules', 1);
    });
    test('authenticated user can delete a schedule', function () {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $schedule = Schedule::factory()->create();
        deleteJson("schedules/{$schedule->id}")
            ->assertStatus(302);
        $this->assertDatabaseCount('schedules', 0);
    });
});


describe('Edit Schedule', function () {
    test('guest user cannot edit a schedule', function () {
        $schedule = Schedule::factory()->create();
        $data = Schedule::factory()->raw();
        putJson("schedules/{$schedule->id}", $data)
            ->assertStatus(401);
        $this->assertdatabaseHas('schedules', [
            'id' => $schedule->id,
            'title' => $schedule->title,
            'description' => $schedule->description,
            'start_date' => $schedule->start_date,
            'deadline_date' => $schedule->deadline_date,
            'conclusion_date' => $schedule->conclusion_date,
            'status' => $schedule->status,
            'id_user' => $schedule->id_user,
        ]);
    });
    test('authenticated user can edit a schedule', function () {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $schedule = Schedule::factory()->create();
        $data = Schedule::factory()->raw();
        putJson("schedules/{$schedule->id}", $data)
            ->assertStatus(302);
    });
});
