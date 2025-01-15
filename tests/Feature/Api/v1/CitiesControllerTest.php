<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;

uses(RefreshDatabase::class);

it('index cities right json for data', function (): void {

    $response = $this->getJson(
        uri: route('api.v1.cities.index'),
    );

    $response->assertStatus(Response::HTTP_OK);
    $response->assertJsonStructure([
        'data' => [
            '*' => [
                'id',
                'name',
            ],
        ],
        'links' => [
            'first',
            'last',
            'prev',
            'next',
        ],
        'meta' => [
            'current_page',
            'from',
            'last_page',
            'links' => [
                '*' => [
                    'url',
                    'label',
                    'active',
                ],
            ],
            'path',
            'per_page',
            'to',
            'total',
        ],
    ]);
});

it('shows a cities with country', function (): void {
    // send request to show
    $response = $this->getJson(route('api.v1.cities.show', 1).'?include=country');

    $response->assertStatus(Response::HTTP_OK)
        ->assertJson(['data' => [
            'id' => 1,
            'name' => 'Alba Iulia',
            'country' => [
                'id' => 182,
                'name' => 'Romania',
                'code' => 'RO',
            ],
        ],
        ]);
});
