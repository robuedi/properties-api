<?php

use App\Enums\PropertyStatus;
use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;

uses(RefreshDatabase::class);

it('index properties right json for no data', function (): void {
    $response = $this->getJson(
        uri: route('api.v1.properties.index'),
    );

    $response
        ->assertStatus(Response::HTTP_OK)
        ->assertJson(
            [
                'data' => [],
                'links' => [
                    'first' => route('api.v1.properties.index').'?page=1',
                    'last' => route('api.v1.properties.index').'?page=1',
                    'prev' => null,
                    'next' => null,
                ],
                'meta' => [
                    'current_page' => 1,
                    'from' => null,
                    'last_page' => 1,
                    'links' => [
                        [
                            'url' => null,
                            'label' => '&laquo; Previous',
                            'active' => false,
                        ],
                        [
                            'url' => route('api.v1.properties.index').'?page=1',
                            'label' => '1',
                            'active' => true,
                        ],
                        [
                            'url' => null,
                            'label' => 'Next &raquo;',
                            'active' => false,
                        ],
                    ],
                    'path' => route('api.v1.properties.index'),
                    'per_page' => 15,
                    'to' => null,
                    'total' => 0,
                ],
            ]);
});

it('index properties right json for data', function (): void {

    // make the fake data
    User::factory()->count(58)->create();
    Property::factory()->count(127)->create();

    $response = $this->getJson(
        uri: route('api.v1.properties.index'),
    );

    $response->assertStatus(Response::HTTP_OK);
    $this->assertCount(15, $response->json('data'));
    $response->assertJsonStructure([
        'data' => [
            '*' => [
                'id',
                'name',
                'slug',
                'owner_id',
                'status_id',
            ],
        ],
    ])
        ->assertJson(
            [
                'data' => [],
                'links' => [
                    'first' => route('api.v1.properties.index').'?page=1',
                    'last' => route('api.v1.properties.index').'?page=9',
                    'prev' => null,
                    'next' => route('api.v1.properties.index').'?page=2',
                ],
                'meta' => [
                    'current_page' => 1,
                    'from' => 1,
                    'last_page' => 9,
                    'links' => [
                        [
                            'url' => null,
                            'label' => '&laquo; Previous',
                            'active' => false,
                        ],
                        [
                            'url' => route('api.v1.properties.index').'?page=1',
                            'label' => '1',
                            'active' => true,
                        ],
                        [
                            'url' => route('api.v1.properties.index').'?page=2',
                            'label' => '2',
                            'active' => false,
                        ],
                        [
                            'url' => route('api.v1.properties.index').'?page=3',
                            'label' => '3',
                            'active' => false,
                        ],
                        [
                            'url' => route('api.v1.properties.index').'?page=4',
                            'label' => '4',
                            'active' => false,
                        ],
                        [
                            'url' => route('api.v1.properties.index').'?page=5',
                            'label' => '5',
                            'active' => false,
                        ],
                        [
                            'url' => route('api.v1.properties.index').'?page=6',
                            'label' => '6',
                            'active' => false,
                        ],
                        [
                            'url' => route('api.v1.properties.index').'?page=7',
                            'label' => '7',
                            'active' => false,
                        ],
                        [
                            'url' => route('api.v1.properties.index').'?page=8',
                            'label' => '8',
                            'active' => false,
                        ],
                        [
                            'url' => route('api.v1.properties.index').'?page=9',
                            'label' => '9',
                            'active' => false,
                        ],
                        [
                            'url' => route('api.v1.properties.index').'?page=2',
                            'label' => 'Next &raquo;',
                            'active' => false,
                        ],
                    ],
                    'path' => route('api.v1.properties.index'),
                    'per_page' => 15,
                    'to' => 15,
                    'total' => 127,
                ],
            ]);
});

it('fails to stores a valid property when unautenticated (unauthorized:401)', function (): void {
    // send request to create
    $recordData = [
        'name' => 'Great Villa',
        'owner_id' => 999,
        'status_id' => 999,
    ];
    $response = $this->postJson(route('api.v1.properties.store'), $recordData);

    $response->assertUnauthorized();
});

it('stores a valid property', function (): void {
    $user = User::factory()->create();

    // send request to create
    $recordData = [
        'name' => 'Great Villa',
        'status_id' => fake()->randomElement(PropertyStatus::values()),
    ];
    $response = $this->actingAs($user)->postJson(route('api.v1.properties.store'), $recordData);

    $response->assertStatus(Response::HTTP_CREATED);
    $response->assertHeader('Content-Type', 'application/json');
    $response->assertJson([
        'data' => [
            'id' => 1,
        ],
    ]);

    $this->assertDatabaseHas((new Property)->getTable(), $recordData);
});

it('stores a valid property with the right user id even if different user id is sent', function (): void {
    $user = User::factory()->create();
    $testUser = User::factory()->create();

    // send request to create
    $recordData = [
        'name' => 'Great Villa',
        'owner_id' => $testUser->id,
        'status_id' => fake()->randomElement(PropertyStatus::values()),
    ];
    $response = $this->actingAs($user)->postJson(route('api.v1.properties.store'), $recordData);

    $response->assertStatus(Response::HTTP_CREATED);
    $response->assertHeader('Content-Type', 'application/json');
    $response->assertJson([
        'data' => [
            'id' => 1,
        ],
    ]);

    $this->assertDatabaseHas((new Property)->getTable(), [...$recordData, ...['owner_id' => $user->id]]);
});

it('fails to store an empty property', function (): void {
    $user = User::factory()->create();

    // send request to create
    $response = $this->actingAs($user)->postJson(route('api.v1.properties.store'), []);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    $response->assertHeader('Content-Type', 'application/json');
    $response->assertJson([
        'message' => 'The name field is required. (and 1 more error)',
        'errors' => [
            'name' => ['The name field is required.'],
            'status_id' => ['The status id field is required.'],
        ],
    ]);
});

it('fails to store wrong values for a property', function (): void {
    $user = User::factory()->create();

    // send request to create
    $response = $this->actingAs($user)->postJson(route('api.v1.properties.store'), [
        'name' => 'a',
        'status_id' => 91,
    ]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    $response->assertHeader('Content-Type', 'application/json');
    $response->assertJson([
        'message' => 'The name field must be at least 3 characters. (and 1 more error)',
        'errors' => [
            'name' => ['The name field must be at least 3 characters.'],
            'status_id' => ['The selected status id is invalid.'],
        ],
    ]);
});

it('requires to be authenticated to try to update a property', function (): void {
    // send request to update
    $response = $this->putJson(route('api.v1.properties.update', 999), [
        'name' => 'Moon Villa',
        'status_id' => PropertyStatus::Inactive->value,
    ]);

    $response->assertUnauthorized();
});

it('requires to be autorized to update a property', function (): void {
    // make a property
    $property = Property::factory()->create();

    // send request to update
    $anotherUser = User::factory()->create();
    $response = $this->actingAs($anotherUser)->putJson(route('api.v1.properties.update', $property->id), [
        'name' => 'Moon Villa',
        'status_id' => PropertyStatus::Inactive->value,
    ]);

    $response->assertForbidden();
});

it('updates a property with only the allowed fields', function (): void {
    $user = User::factory()->create();
    $propertyData = [
        'name' => 'Sea Villa',
        'owner_id' => $user->id,
        'status_id' => PropertyStatus::Active->value,
    ];

    $property = Property::factory()->create($propertyData);

    // send request to update
    $failUser = User::factory()->create();
    $response = $this->actingAs($user)->putJson(route('api.v1.properties.update', $property->id), [
        'id' => '5',
        'name' => 'Moon Villa',
        'owner_id' => $failUser->id,
        'status_id' => PropertyStatus::Inactive->value,
    ]);

    $response->assertStatus(Response::HTTP_NO_CONTENT);

    // the correct data
    $this->assertDatabaseHas((new Property)->getTable(), [
        'id' => $property->id,
        'name' => 'Moon Villa',
        'owner_id' => $user->id,
        'status_id' => PropertyStatus::Inactive->value,
    ]);
});

it('returns 404 for update on a non-existing property', function (): void {

    $user = User::factory()->create();
    $response = $this->actingAs($user)->putJson(route('api.v1.properties.update', 1), [
        'name' => 'Moon Villa',
        'owner_id' => $user->id,
        'status_id' => PropertyStatus::Inactive->value,
    ]);

    $response->assertStatus(Response::HTTP_NOT_FOUND);
});

it('shows a property', function (): void {
    $user = User::factory()->create();
    $propertyData = [
        'name' => 'Sea Villa',
        'owner_id' => $user->id,
        'status_id' => PropertyStatus::Active->value,
    ];

    $property = Property::factory()->create($propertyData);

    // send request to show
    $response = $this->getJson(route('api.v1.properties.show', $property->id));

    $response->assertStatus(Response::HTTP_OK)
        ->assertJson(['data' => [
            ...['id' => $property->id],
            ...$propertyData],
        ]
        );
});

it('returns 404 for request to show a non-existing property', function (): void {
    // send request to show
    $response = $this->getJson(route('api.v1.properties.show', 1));
    $response->assertStatus(Response::HTTP_NOT_FOUND);
});

it('returns 401(unauthorized) when trying to delete a property without being authenticated', function (): void {
    // send request to delete
    $response = $this->deleteJson(route('api.v1.properties.destroy', 999));

    $response->assertUnauthorized();
});

it('returns 403(forbidden) when trying to delete a property that is owned by a different user', function (): void {
    $property = Property::factory()->create();
    $user = User::factory()->create();

    // send request to delete
    $response = $this->actingAs($user)->deleteJson(route('api.v1.properties.destroy', $property->id));

    $response->assertForbidden();
});

it('deletes a property', function (): void {
    $user = User::factory()->create();
    $propertyData = [
        'name' => 'Sea Villa',
        'owner_id' => $user->id,
        'status_id' => PropertyStatus::Active->value,
    ];

    $property = Property::factory()->create($propertyData);

    // send request to delete
    $response = $this->actingAs($user)->deleteJson(route('api.v1.properties.destroy', $property->id));

    $response->assertStatus(Response::HTTP_NO_CONTENT);
    $this->assertDatabaseMissing((new Property)->getTable(), ['id' => $property->id]);

    // send request to delete again
    $response = $this->actingAs($user)->deleteJson(route('api.v1.properties.destroy', $property->id));
    $response->assertStatus(Response::HTTP_NOT_FOUND);
});
