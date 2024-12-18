<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\StorePropertyRequest;
use App\Http\Requests\v1\UpdatePropertyRequest;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\Property;
use App\Http\Resources\v1\PropertyResource;
use Illuminate\Http\Response;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $properties = QueryBuilder::for(Property::class)
            ->allowedFields([
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
            ])
            ->defaultSort('-created_at')
            ->allowedIncludes(['owner', 'status', 'address', 'address.city', 'address.city.country'])
            ->paginate()
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
