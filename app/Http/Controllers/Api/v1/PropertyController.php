<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\StorePropertyRequest;
use App\Http\Requests\v1\UpdatePropertyRequest;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\Property;
use App\Http\Resources\v1\PropertyResource;
use Illuminate\Http\Response;
use App\Http\Requests\GenericListingRequest;

class PropertyController extends Controller
{
    /**
     * List properties
     */
    public function index(GenericListingRequest $request)
    {
        $allowedFields = [
            'id', 
            'name',
            'slug',
            'owner_id',
            'status_id',
            'created_at',
            'updated_at',
            'owner.id',
            'owner.name',
            'status.id',
            'status.name',  
            'address.id', 
            'address.city_id', 
            'address.address_line',
        ];

        $request->validate([
            /**
             * Fields properties
             * @example id,name,slug,owner_id,status_id,created_at,updated_at
             */
            'fields[properties]' => 'string',

            /**
             * Fields owner
             * @example id,name
             */
            'fields[owner]' => 'string',

            /**
             * Fields address
             * @example id,city_id,address_line,created_at,updated_at
             */
            'fields[address]' => 'string',

            /**
             * Filter name
             * @example house
             */
            'filter[name]' => 'string',
            
            /**
             * Relationships.
             * @example owner,status,address,address.city,address.city.country
             */
            'include' => 'string',
            'sort' => 'in:created_at,-created_at',
        ]);

        $properties = QueryBuilder::for(Property::class)
            ->allowedFields($allowedFields)
            ->defaultSort('-created_at')
            ->allowedIncludes(['owner', 'status', 'address', 'address.city', 'address.city.country'])
            ->allowedFilters(['name'])
            ->allowedSorts('created_at', '-created_at')
            ->paginate(request('per_page', 15))
            ->appends(request()->query());

        return PropertyResource::collection($properties)->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePropertyRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePropertyRequest $request, Property $property)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        //
    }
}
