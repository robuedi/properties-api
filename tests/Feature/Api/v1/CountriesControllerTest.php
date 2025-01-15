<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;

uses(RefreshDatabase::class);

it('index countries right json for data', function (): void {

    $response = $this->getJson(
        uri: route('api.v1.countries.index'),
    );

    $response->assertStatus(Response::HTTP_OK);
    $this->assertCount(15, $response->json('data'));
    $response->assertJsonStructure([
        'data' => [
            '*' => [
                'id',
                'name',
            ],
        ],
    ])
        ->assertJson(
            [
                'data' => [],
                'links' => [
                    'first' => route('api.v1.countries.index').'?page=1',
                    'last' => route('api.v1.countries.index').'?page=17',
                    'prev' => null,
                    'next' => route('api.v1.countries.index').'?page=2',
                ],
                'meta' => [
                    'current_page' => 1,
                    'from' => 1,
                    'last_page' => 17,
                    'links' => [
                        [
                            'url' => null,
                            'label' => '&laquo; Previous',
                            'active' => false,
                        ],
                        [
                            'url' => route('api.v1.countries.index').'?page=1',
                            'label' => '1',
                            'active' => true,
                        ],
                        [
                            'url' => route('api.v1.countries.index').'?page=2',
                            'label' => '2',
                            'active' => false,
                        ],
                        [
                            'url' => route('api.v1.countries.index').'?page=3',
                            'label' => '3',
                            'active' => false,
                        ],
                        [
                            'url' => route('api.v1.countries.index').'?page=4',
                            'label' => '4',
                            'active' => false,
                        ],
                        [
                            'url' => route('api.v1.countries.index').'?page=5',
                            'label' => '5',
                            'active' => false,
                        ],
                        [
                            'url' => route('api.v1.countries.index').'?page=6',
                            'label' => '6',
                            'active' => false,
                        ],
                        [
                            'url' => route('api.v1.countries.index').'?page=7',
                            'label' => '7',
                            'active' => false,
                        ],
                        [
                            'url' => route('api.v1.countries.index').'?page=8',
                            'label' => '8',
                            'active' => false,
                        ],
                        [
                            'url' => route('api.v1.countries.index').'?page=9',
                            'label' => '9',
                            'active' => false,
                        ],
                        [
                            'url' => route('api.v1.countries.index').'?page=10',
                            'label' => '10',
                            'active' => false,
                        ],
                        [
                            'url' => null,
                            'label' => '...',
                            'active' => false,
                        ],
                        [
                            'url' => route('api.v1.countries.index').'?page=16',
                            'label' => '16',
                            'active' => false,
                        ],
                        [
                            'url' => route('api.v1.countries.index').'?page=17',
                            'label' => '17',
                            'active' => false,
                        ],
                        [
                            'url' => route('api.v1.countries.index').'?page=2',
                            'label' => 'Next &raquo;',
                            'active' => false,
                        ],
                    ],
                    'path' => route('api.v1.countries.index'),
                    'per_page' => 15,
                    'to' => 15,
                    'total' => 249,
                ],
            ]);
});

it('shows a country with cities', function (): void {

    // send request to show
    $response = $this->getJson(route('api.v1.countries.show', 182).'?include=cities');

    $response->assertStatus(Response::HTTP_OK)
        ->assertJson(['data' => [
            'id' => 182,
            'name' => 'Romania',
            'cities' => [],
        ],
        ])
        ->assertJsonStructure([
            'data' => [
                'cities' => [
                    '*' => [
                        'id',
                        'name',
                    ],
                ],
            ],
        ]);
});
