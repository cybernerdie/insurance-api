<?php

declare(strict_types=1);

use App\Models\User;
use function Pest\Laravel\{actingAs, postJson};

beforeEach(function () {    
    $this->user = User::factory()->create();

    actingAs($this->user, 'api');
    
    $this->route = route('api.quotation.index');
});

it('retrieves a quotation successfully', function () {
    $data = [
        'age' => '28,35',
        'currency_id' => 'USD',
        'start_date' => '2020-10-01',
        'end_date' => '2020-10-30',
    ];

    $response = postJson($this->route, $data);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'message',
            'data' => [
                'total',
                'currency_id',
                'quotation_id',
            ],
        ])->assertJsonFragment([
            'message' => 'Quotation retrieved successfully.',
            'total' => '117.00',
            'currency_id' => 'USD',
        ])->assertJsonPath('data.quotation_id', fn ($id) => is_int($id));
});

it('fails to retrieve a quotation with invalid data', function () {
    $data = [
        'age' => '10,another',
        'currency_id' => 'USD',
        'start_date' => '2025-01-01',
        'end_date' => '2025-01-10',
    ];

    $response = postJson($this->route, $data);

    $response->assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors' => [
                'age',
            ],
        ]);
});

it('fails to retrieve a quotation when age is out of range', function () {
    $data = [
        'age' => '17,100',
        'currency_id' => 'USD',
        'start_date' => '2025-01-01',
        'end_date' => '2025-01-10',
    ];    

    $response = postJson($this->route, $data);

    $response->assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors' => [
                'age',
            ],
        ]);
});

it('fails to retrieve a quotation with invalid dates', function () {
    $data = [
        'age' => '30',
        'currency_id' => 'USD',
        'start_date' => '2025-01-01',
        'end_date' => '2024-01-10',
    ];

    $response = postJson($this->route, $data);  

    $response->assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors' => [
                'end_date',
            ],
        ]);
}); 

it('fails to retrieve a quotation with invalid currency', function () {
    $data = [
        'age' => '30',
        'currency_id' => 'invalid',
        'start_date' => '2025-01-01',
        'end_date' => '2025-01-10',
    ];

    $response = postJson($this->route, $data);

    $response->assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors' => [
                'currency_id',
            ],
        ]);
});