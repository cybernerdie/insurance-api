<?php

declare(strict_types=1);

use App\Models\User;
use App\Actions\Quotation\GetQuotationAction;
use function Pest\Laravel\{actingAs, postJson, assertDatabaseHas};

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
        ])
        ->assertJson([
            'message' => 'Quotation retrieved successfully.',
            'data' => [
                'total' => '117.00',
                'currency_id' => 'USD',
                'quotation_id' => 1,
            ],
        ]);
});

it('returns an error if the quotation retrieval fails', function () {
    $data = [
        'age' => '30',
        'currency_id' => 'USD',
        'start_date' => '2025-01-01',
        'end_date' => '2025-01-10',
    ];

    $this->mock(GetQuotationAction::class, function ($mock) {
        $mock->shouldReceive('execute')
            ->once()
            ->andThrow(new \Exception('Quotation retrieval error'));
    });

    $response = postJson($this->route, $data);

    $response->assertStatus(500)
        ->assertJson([
            'message' => 'Failed to retrieve quotation. Please try again later.',
        ]);
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