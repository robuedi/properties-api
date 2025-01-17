<?php

use App\Enums\PropertyStatus;
use App\Models\Property;
use App\Models\PropertyAddress;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;

uses(RefreshDatabase::class);

it('stores an address for the property', function (): void {
    $user = User::factory()->create();
    $property = Property::factory()->create([
        'name' => 'Sea Villa',
        'owner_id' => $user->id,
        'status_id' => PropertyStatus::Active->value,
    ]);

    $recordData = [
        'city_id' => 1,
        'address_line' => 'Test Street, nr. 1'
    ];

    $response = $this->actingAs($user)->postJson(route('api.v1.properties.address.store', ['property' => $property->id]), $recordData);

    $response->assertStatus(Response::HTTP_NO_CONTENT)
             ->assertNoContent();
  
    $this->assertDatabaseHas((new PropertyAddress)->getTable(), [...$recordData, 'property_id' => $property->id]);
});

it('stores an address for the property only if request from owner', function (): void {
    $user = User::factory()->create();
    $property = Property::factory()->create([
        'name' => 'Sea Villa',
        'owner_id' => $user->id,
        'status_id' => PropertyStatus::Active->value,
    ]);

    $anotherUser = User::factory()->create();
    $response = $this->actingAs($anotherUser)->postJson(route('api.v1.properties.address.store', ['property' => $property->id]), [
        'city_id' => 1,
        'address_line' => 'Test Street, nr. 1'
    ]);

    $response->assertForbidden();
});

it('allows to store only one address per property', function (): void {
    $user = User::factory()->create();
    $property = Property::factory()->create([
        'name' => 'Sea Villa',
        'owner_id' => $user->id,
        'status_id' => PropertyStatus::Active->value,
    ]);

    $recordData = [
        'city_id' => 1,
        'address_line' => 'Test Street, nr. 1'
    ];

    $response = $this->actingAs($user)->postJson(route('api.v1.properties.address.store', ['property' => $property->id]), [
        'city_id' => 1,
        'address_line' => 'Test Street, nr. 1'
    ]);
    $response2 = $this->actingAs($user)->postJson(route('api.v1.properties.address.store', ['property' => $property->id]), [
        'city_id' => 2,
        'address_line' => 'Test Street 2, nr. 2'
    ]);

    $response2->assertStatus(Response::HTTP_CONFLICT);
});

it('return 404 when trying to store an address for a non existing property', function (): void {
    $user = User::factory()->create();

    $recordData = [
        'city_id' => 1,
        'address_line' => 'Test Street, nr. 1'
    ];

    $response = $this->actingAs($user)->postJson(route('api.v1.properties.address.store', ['property' => 1]), $recordData);

    $response->assertStatus(404);
});

it('allows to store only valid address fields for the property', function (): void {
    $user = User::factory()->create();
    $property = Property::factory()->create([
        'name' => 'Sea Villa',
        'owner_id' => $user->id,
        'status_id' => PropertyStatus::Active->value,
    ]);

    $recordData = [
        'city_id' => 0,
        'address_line' => ''
    ];

    $response = $this->actingAs($user)->postJson(route('api.v1.properties.address.store', ['property' => $property->id]), $recordData);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    $response->assertHeader('Content-Type', 'application/json');
    $response->assertJson([
        'message' => 'The selected city id is invalid. (and 1 more error)',
        'errors' => [
            'city_id' => ['The selected city id is invalid.'],
            'address_line' => ['The address line field must be a string.'],
        ],
    ]);
});