<?php

declare(strict_types=1);

use App\Models\User;
use App\Actions\Auth\CreateUserAction;
use function Pest\Laravel\{postJson, assertDatabaseHas};

beforeEach(function () {
    installPassportClient();

    $this->route = route('api.auth.register');
});

it('registers a user successfully', function () {
    $data = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ];

    $response = postJson($this->route, $data);

    $response->assertStatus(200)
        ->assertJson([
            'message' => 'Registration successful',
            'data' => [
                'user' => [
                    'name' => 'John Doe',
                    'email' => 'john@example.com',
                ],
            ],
        ]);


    assertDatabaseHas('users', [
        'email' => 'john@example.com',
        'name' => 'John Doe',
    ]);
});

it('fails to register a user with invalid data', function () {
    $data = [
        'name' => '', 
        'email' => 'not-an-email',
        'password' => '123', 
    ];

    $response = postJson($this->route, $data);

    $response->assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors' => [
                'name',
                'email',
                'password',
            ],
        ]);
});

it('ensures email uniqueness during registration', function () {
    User::factory()->create([
        'email' => 'john@example.com',
    ]);

    $data = [
        'name' => 'Jane Doe',
        'email' => 'john@example.com', // Duplicate email
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ];

    $response = postJson($this->route, $data);

    $response->assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors' => [
                'email',
            ],
        ]);
});
