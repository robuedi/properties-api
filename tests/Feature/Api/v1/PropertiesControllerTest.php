<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\Api\v1\PropertyController;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Models\Property;
use App\Models\User;

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
