<?php

declare(strict_types=1);

use App\Models\User;
use function Pest\Laravel\{postJson, assertDatabaseHas};

beforeEach(function () {
    installPassportClient();

    $this->route = route('api.auth.login');
});

it('logs in a user successfully', function () {
    $user = User::factory()->create([
        'password' => 'password123',
    ]);

    $data = [
        'email' => $user->email,
        'password' => 'password123',
    ];

    $response = postJson($this->route, $data);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'message',
            'data' => [
                'user' => [
                    'name',
                    'email',
                ],
                'token',
            ],
        ])
        ->assertJson([
            'message' => 'Login successful.',
            'data' => [
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ],
        ]);
});

it('fails to log in with invalid credentials', function () {
    User::factory()->create([
        'email' => 'john@example.com',
        'password' => 'password123',
    ]);

    $data = [
        'email' => 'john@example.com',
        'password' => 'wrong-password',
    ];

    $response = postJson($this->route, $data);

    $response->assertStatus(422)
        ->assertJson([
            'message' => 'These credentials do not match our records.',
        ]);
});

it('fails to log in with missing data', function () {
    $data = [];

    $response = postJson($this->route, $data);

    $response->assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors' => [
                'email',
                'password',
            ],
        ]);
});
