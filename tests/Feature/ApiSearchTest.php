<?php

use App\Models\Hotel;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('unauthenticated request to search returns 401', function () {
    $response = $this->getJson('/api/search?'.http_build_query([
        'city' => 'Cairo',
        'checkin_date' => now()->addDays(2)->format('Y-m-d'),
        'checkout_date' => now()->addDays(5)->format('Y-m-d'),
        'guests' => 1,
    ]));

    $response->assertUnauthorized();
});

test('search with missing required params returns 422', function () {
    $user = User::factory()->create();
    $token = $user->createToken('test')->plainTextToken;

    $response = $this->getJson('/api/search', [
        'Authorization' => 'Bearer '.$token,
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['checkin_date', 'checkout_date', 'guests']);
});

test('search with checkin_date before today returns 422', function () {
    $user = User::factory()->create();
    $token = $user->createToken('test')->plainTextToken;

    $response = $this->getJson('/api/search?'.http_build_query([
        'checkin_date' => now()->subDay()->format('Y-m-d'),
        'checkout_date' => now()->addDays(2)->format('Y-m-d'),
        'guests' => 1,
    ]), [
        'Authorization' => 'Bearer '.$token,
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['checkin_date']);
});

test('search with checkout_date before checkin_date returns 422', function () {
    $user = User::factory()->create();
    $token = $user->createToken('test')->plainTextToken;

    $checkin = now()->addDays(5)->format('Y-m-d');
    $checkout = now()->addDays(2)->format('Y-m-d');

    $response = $this->getJson('/api/search?'.http_build_query([
        'checkin_date' => $checkin,
        'checkout_date' => $checkout,
        'guests' => 1,
    ]), [
        'Authorization' => 'Bearer '.$token,
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['checkout_date']);
});

test('valid search request returns 200 and expected structure', function () {
    $user = User::factory()->create();
    $token = $user->createToken('test')->plainTextToken;

    Hotel::factory()->has(Room::factory()->count(2))->create(['city' => 'Cairo']);

    $response = $this->getJson('/api/search?'.http_build_query([
        'city' => 'Cairo',
        'checkin_date' => now()->addDays(2)->format('Y-m-d'),
        'checkout_date' => now()->addDays(5)->format('Y-m-d'),
        'guests' => 1,
    ]), [
        'Authorization' => 'Bearer '.$token,
    ]);

    $response->assertSuccessful();
    $response->assertJsonStructure([
        'data' => [
            '*' => [
                'id',
                'name',
                'city',
                'country',
                'rating',
            ],
        ],
    ]);

    $data = $response->json('data');
    expect($data)->toBeArray();
    if (count($data) > 0) {
        expect($data[0])->toHaveKeys(['id', 'name', 'city', 'country', 'rating']);
        if (isset($data[0]['rooms'])) {
            expect($data[0]['rooms'])->toBeArray();
            foreach ($data[0]['rooms'] as $room) {
                expect($room)->toHaveKeys(['id', 'hotel_id', 'name', 'price_per_night', 'max_occupancy', 'available_rooms', 'rooms_count']);
            }
        }
    }
});
