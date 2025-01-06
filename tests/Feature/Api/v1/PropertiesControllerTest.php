<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\Api\v1\PropertyController;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Models\Property;
use App\Models\User;
use App\Enums\PropertyStatus;

uses(RefreshDatabase::class);

it('index properties right json for no data', function (): void {
    $response = $this->getJson(
        uri: route('api.v1.properties.index'),
    );
    
    $response
    ->assertStatus(Response::HTTP_OK)
    ->assertJson(
    [
        'data'=> [],
        'links'=> [
            'first'=> route('api.v1.properties.index').'?page=1',
            'last'=> route('api.v1.properties.index').'?page=1',
            'prev'=> null,
            'next'=> null
        ],
        'meta'=> [
            'current_page'=> 1,
            'from'=> null,
            'last_page'=> 1,
            'links'=> [
                [
                    'url'=> null,
                    'label'=> '&laquo; Previous',
                    'active'=> false
                ],
                [
                    'url'=> route('api.v1.properties.index').'?page=1',
                    'label'=> '1',
                    'active'=> true
                ],
                [
                    'url'=> null,
                    'label'=> 'Next &raquo;',
                    'active'=> false
                ]
            ],
            'path'=> route('api.v1.properties.index'),
            'per_page'=> 15,
            'to'=> null,
            'total'=> 0
        ]
    ]);
});

it('index properties right json for data', function (): void {

    //make the fake data
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
        ]
    ])
    ->assertJson(
    [
        'data' => [],
        'links'=> [
            'first'=> route('api.v1.properties.index').'?page=1',
            'last'=> route('api.v1.properties.index').'?page=9',
            'prev'=> null,
            'next'=> route('api.v1.properties.index').'?page=2'
        ],
        'meta'=> [
            'current_page'=> 1,
            'from'=> 1,
            'last_page'=> 9,
            'links'=> [
                [
                    'url'=> null,
                    'label'=> '&laquo; Previous',
                    'active'=> false
                ],
                [
                    'url'=> route('api.v1.properties.index').'?page=1',
                    'label'=> '1',
                    'active'=> true
                ],
                [
                    'url'=> route('api.v1.properties.index').'?page=2',
                    'label'=> '2',
                    'active'=> false
                ],
                [
                    'url'=> route('api.v1.properties.index').'?page=3',
                    'label'=> '3',
                    'active'=> false
                ],
                [
                    'url'=> route('api.v1.properties.index').'?page=4',
                    'label'=> '4',
                    'active'=> false
                ],
                [
                    'url'=> route('api.v1.properties.index').'?page=5',
                    'label'=> '5',
                    'active'=> false
                ],
                [
                    'url'=> route('api.v1.properties.index').'?page=6',
                    'label'=> '6',
                    'active'=> false
                ],
                [
                    'url'=> route('api.v1.properties.index').'?page=7',
                    'label'=> '7',
                    'active'=> false
                ],
                [
                    'url'=> route('api.v1.properties.index').'?page=8',
                    'label'=> '8',
                    'active'=> false
                ],
                [
                    'url'=> route('api.v1.properties.index').'?page=9',
                    'label'=> '9',
                    'active'=> false
                ],
                [
                    'url'=> route('api.v1.properties.index').'?page=2',
                    'label'=> 'Next &raquo;',
                    'active'=> false
                ]
            ],
            'path'=> route('api.v1.properties.index'),
            'per_page'=> 15,
            'to'=> 15,
            'total'=> 127
        ]
    ]);
});


it('store a valid property', function (): void {
    $user = User::factory()->create();

    //send request to create
    $response = $this->postJson(route('api.v1.properties.store'), [
        'name' => 'Great Villa',
        'owner_id' => $user->id,
        'status_id' => fake()->randomElement(PropertyStatus::values()),
    ]);

    $response->assertStatus(201);
    $response->assertHeader('Content-Type', 'application/json');
    $response->assertJson([
        'data' => [
            'id' => 1,
        ]
    ]);
});

it('store failed for empty property', function (): void {

    //send request to create
    $response = $this->postJson(route('api.v1.properties.store'), []);

    $response->assertStatus(422);
    $response->assertHeader('Content-Type', 'application/json');
    $response->assertJson([
        'message' => 'The name field is required. (and 2 more errors)',
        'errors'=> [
            'name' => ['The name field is required.'],
            'owner_id' => ['The owner id field is required.'],
            'status_id' => ['The status id field is required.']
        ]
    ]);
});

it('store failed for wrong values property', function (): void {

    //send request to create
    $response = $this->postJson(route('api.v1.properties.store'), [
        'name' => 'a',
        'owner_id' => 7,
        'status_id' => 91,
    ]);

    $response->assertStatus(422);
    $response->assertHeader('Content-Type', 'application/json');
    $response->assertJson([
        'message' => 'The name field must be at least 3 characters. (and 2 more errors)',
        'errors'=> [
            'name' => ['The name field must be at least 3 characters.'],
            'owner_id' => ['The selected owner id is invalid.'],
            'status_id' => ['The selected status id is invalid.']
        ]
    ]);
});
