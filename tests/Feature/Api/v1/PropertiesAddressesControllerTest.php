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
        'address_line' => 'Test Street, nr. 1',
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
        'address_line' => 'Test Street, nr. 1',
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
        'address_line' => 'Test Street, nr. 1',
    ];

    $response = $this->actingAs($user)->postJson(route('api.v1.properties.address.store', ['property' => $property->id]), [
        'city_id' => 1,
        'address_line' => 'Test Street, nr. 1',
    ]);
    $response2 = $this->actingAs($user)->postJson(route('api.v1.properties.address.store', ['property' => $property->id]), [
        'city_id' => 2,
        'address_line' => 'Test Street 2, nr. 2',
    ]);

    $response2->assertStatus(Response::HTTP_CONFLICT);
});

it('return 404 when trying to store an address for a non existing property', function (): void {
    $user = User::factory()->create();

    $recordData = [
        'city_id' => 1,
        'address_line' => 'Test Street, nr. 1',
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
        'address_line' => '',
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

it('updates an address for the property only if request from the owner', function (): void {
    $property = Property::factory()->create();

    $anotherUser = User::factory()->create();
    $response = $this->actingAs($anotherUser)->postJson(route('api.v1.properties.address.update', ['property' => $property->id]), [
        'city_id' => 1,
        'address_line' => 'Test Street, nr. 1',
    ]);

    $response->assertForbidden();
});

it('updates the address for the property', function (): void {
    $property = Property::factory()->hasAddress(1, [
        'city_id' => 1,
        'address_line' => 'Test Street, nr. 1',
    ])->create();

    $updateData = [
        'city_id' => 3,
        'address_line' => 'Test Street 3, nr. 3',
    ];

    $response = $this->actingAs($property->owner)->putJson(route('api.v1.properties.address.update', ['property' => $property->id]), $updateData);

    $response->assertStatus(Response::HTTP_NO_CONTENT)
        ->assertNoContent();

    $this->assertDatabaseHas((new PropertyAddress)->getTable(), [...$updateData, 'property_id' => $property->id]);
});

it('return 404 when trying to update an address for a non existing property', function (): void {
    $response = $this->actingAs(User::factory()->create())
        ->postJson(route('api.v1.properties.address.store', ['property' => 1]), [
            'city_id' => 1,
            'address_line' => 'Test Street, nr. 1',
        ]);

    $response->assertStatus(404);
});

it('returns 404 and correct message when trying to update a missing property address', function (): void {
    $property = Property::factory()->create();

    $updateData = [
        'city_id' => 3,
        'address_line' => 'Test Street 3, nr. 3',
    ];

    $response = $this->actingAs($property->owner)->putJson(route('api.v1.properties.address.update', ['property' => $property->id]), $updateData);

    $response->assertStatus(404);
    $response->assertHeader('Content-Type', 'application/json');
    $response->assertJson([
        'message' => 'Address not found for the specified property.',
    ],
    );
});

it('allows to update only valid address fields for the property', function (): void {
    $property = Property::factory()->withAddress()->create();

    $response = $this->actingAs($property->owner)->postJson(route('api.v1.properties.address.update', ['property' => $property->id]), [
        'city_id' => 0,
        'address_line' => '',
    ]);

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

it('shows the address of an active property without being authenticated', function (): void {
    $property = Property::factory()->withAddress()->create([
        'status_id' => PropertyStatus::Active->value,
    ]);

    // send request to show
    $response = $this->getJson(route('api.v1.properties.address.show', ['property' => $property->id]));

    $response->assertStatus(Response::HTTP_OK)
        ->assertJson(['data' => $property->address?->only(['city_id', 'address_line'])]);
});

it('returns 403/forbidden when showing the address of an inactive property without authenticated', function (): void {
    $property = Property::factory()->withAddress()->create([
        'status_id' => PropertyStatus::Inactive->value,
    ]);

    // send request to show
    $response = $this->getJson(route('api.v1.properties.address.show', ['property' => $property->id]));

    $response->assertForbidden();
});

it('returns 403/forbidden when showing the address of an inactive property while authenticated, but not as the owner', function (): void {
    $property = Property::factory()->withAddress()->create([
        'status_id' => PropertyStatus::Inactive->value,
    ]);

    // send request to show
    $response = $this->actingAs(User::factory()->create())->getJson(route('api.v1.properties.address.show', ['property' => $property->id]));

    $response->assertForbidden();
});

it('shows the address of an inactive property to the owner of the property', function (): void {
    $property = Property::factory()->withAddress()->create([
        'status_id' => PropertyStatus::Inactive->value,
    ]);

    // send request to show
    $response = $this->actingAs($property->owner)->getJson(route('api.v1.properties.address.show', ['property' => $property->id]));

    $response->assertStatus(Response::HTTP_OK)
        ->assertJson(['data' => $property->address?->only(['city_id', 'address_line'])]);
});

it('returns 404 for request to show the adress of a non-existing property', function (): void {
    // send request to show
    $response = $this->getJson(route('api.v1.properties.address.show', ['property' => 1]));

    $response->assertStatus(404);
    $response->assertJson([
        'message' => 'No query results for model [App\\Models\\Property] 1',
    ]);
});

it('returns 404 for request to show a non-existing adress of a property', function (): void {
    $property = Property::factory()->create([
        'status_id' => PropertyStatus::Active->value,
    ]);

    // send request to show
    $response = $this->getJson(route('api.v1.properties.address.show', ['property' => $property->id]));

    $response->assertStatus(404);
    $response->assertJson([
        'message' => 'Address not found for the specified property.',
    ]);
});

it('returns 401(unauthorized) when trying to delete an address of a property without being authenticated', function (): void {
    $property = Property::factory()->withAddress()->create();

    // send request to delete
    $response = $this->deleteJson(route('api.v1.properties.address.destroy', ['property' => $property->id]));

    $response->assertUnauthorized();
});

it('returns 403(unauthorized) when trying to delete an address of a property without being the owner', function (): void {
    $property = Property::factory()->withAddress()->create();

    // send request to delete
    $response = $this->actingAs(User::factory()->create())->deleteJson(route('api.v1.properties.address.destroy', ['property' => $property->id]));

    $response->assertForbidden();
});

it('returns 404 for request to delete the adress of a non-existing property', function (): void {
    // send request to show
    $response = $this->actingAs(User::factory()->create())->deleteJson(route('api.v1.properties.address.destroy', ['property' => 1]));

    $response->assertStatus(404);
    $response->assertJson([
        'message' => 'No query results for model [App\\Models\\Property] 1',
    ]);
});

it('returns 404 for request to delete a non-existing adress of a property', function (): void {
    $property = Property::factory()->create();

    // send request to show
    $response = $this->actingAs($property->owner)->deleteJson(route('api.v1.properties.address.destroy', ['property' => $property->id]));

    $response->assertStatus(404);
    $response->assertJson([
        'message' => 'Address not found for the specified property.',
    ]);
});

it('deletes the address of a property', function (): void {
    $property = Property::factory()->withAddress()->create();
    $property->load('address');

    // send request to delete
    $response = $this->actingAs($property->owner)->deleteJson(route('api.v1.properties.address.destroy', ['property' => $property->id]));

    $response->assertStatus(Response::HTTP_NO_CONTENT);
    $this->assertDatabaseMissing((new PropertyAddress)->getTable(), $property->address->only('id'));

    // send request to delete again
    $response2 = $this->actingAs($property->owner)->deleteJson(route('api.v1.properties.address.destroy', ['property' => $property->id]));
    $response2->assertStatus(404);
});
