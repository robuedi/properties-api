<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\StorePropertyAddressRequest;
use App\Http\Requests\v1\UpdatePropertyAddressRequest;
use App\Models\PropertyAddress;
use App\Models\Property;
use Illuminate\Http\Response;
use App\Http\Resources\v1\PropertyAddressResource;
use Illuminate\Support\Facades\Gate;
use App\Repositories\PropertyAddressRepository;

class PropertyAddressController extends Controller
{
    public function __construct(
        private PropertyAddressRepository $propertyAddressRepository
    )
    {
        // the user needs to be logged in for these methods to be accessed
        $this->middleware('auth:api')->only('show', 'update', 'store', 'destroy');
    }

    /**
     * Show property address.
     */
    public function show(Property $property)
    {
        Gate::authorize('view', $property);

        //load address
        $property->load('address');

        //check if address exists
        if(!$property->address)
        {
            abort(404);
        }

        return PropertyAddressResource::make($property->address)->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Store property address.
     */
    public function store(StorePropertyAddressRequest $request, Property $property)
    {
        Gate::authorize('update', $property);

        $this->propertyAddressRepository->createPropertyAddressRequest(property: $property);
        
        return response([])->setStatusCode(Response::HTTP_NO_CONTENT);
    }

    /**
     * Update property address.
     */
    public function update(StorePropertyAddressRequest $request, Property $property)
    {
        Gate::authorize('update', $property);

        $this->propertyAddressRepository->updatePropertyAddressRequest(property: $property);

        return response([])->setStatusCode(Response::HTTP_NO_CONTENT);
    }

    /**
     * Delete property address.
     */
    public function destroy(Property $property)
    {
        Gate::authorize('update', $property);

        $this->propertyAddressRepository->deletePropertyAddressRequest(property: $property);

        return response([])->setStatusCode(Response::HTTP_NO_CONTENT);
    }
}
