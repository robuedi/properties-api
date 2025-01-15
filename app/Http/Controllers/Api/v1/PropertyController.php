<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\GenericListingRequest;
use App\Http\Requests\v1\StorePropertyRequest;
use App\Http\Requests\v1\UpdatePropertyRequest;
use App\Http\Resources\v1\PropertyResource;
use App\Models\Property;
use App\Repositories\PropertyRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Spatie\QueryBuilder\QueryBuilder;

class PropertyController extends Controller
{
    public function __construct()
    {
        // the user needs to be logged in for these methods to be accessed
        // if not authenticated he'll receive a 401/unauthorized before reaching the method, thus avoiding unnecessary model binding, validations...
        $this->middleware('auth:api')->only('store', 'update', 'destroy');
    }

    /**
     * List properties
     *
     * @unauthenticated
     */
    public function index(GenericListingRequest $request)
    {
        $request->validate([
            /**
             * Relationships.
             *
             * @example owner,status,address,address.city,address.city.country
             */
            'include' => 'string',

            /**
             * Fields properties
             *
             * @example id,name,slug,owner_id,status_id,created_at,updated_at
             */
            'fields[properties]' => 'string',

            /**
             * Fields owner
             *
             * @example id,name
             */
            'fields[owners]' => 'string',

            /**
             * Fields addresses
             *
             * @example id,city_id,address_line,created_at,updated_at
             */
            'fields[addresses]' => 'string',

            /**
             * Filter name
             *
             * @example house
             */
            'filter[name]' => 'string',

            'sort' => 'in:created_at,-created_at',
        ]);

        $properties = QueryBuilder::for(Property::class)
            ->select('id', 'name', 'slug', 'status_id', 'owner_id')
            ->allowedFields([
                'id',
                'name',
                'slug',
                'owner_id',
                'status_id',
                'created_at',
                'updated_at',
                'owners.id',
                'owners.name',
                'owners.email',
                'statuses.id',
                'statuses.name',
                'addresses.id',
                'addresses.city_id',
                'addresses.address_line',
                'addresses.property_id',
            ])
            ->defaultSort('-created_at')
            ->allowedIncludes(['owner', 'address', 'address.city', 'address.city.country'])
            ->allowedFilters(['name'])
            ->allowedSorts('created_at', '-created_at')
            ->paginate(request('per_page', 15))
            ->appends(request()->query());

        return PropertyResource::collection($properties)->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Store property
     *
     * `slug` field is set automatically using the `name` field when the status is set to <b>active</b> (value 1). Once set it can't be changed.
     */
    public function store(StorePropertyRequest $request, PropertyRepository $propertyRepository)
    {
        // store the new property
        Gate::authorize('create', Property::class);
        $property = $propertyRepository->authUserCreateRequestProperty();

        return response()
            ->json(['data' => [
                'id' => $property->id,
            ]])
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Show property
     *
     * @unauthenticated
     */
    public function show(Request $request, int $property)
    {
        $request->validate([
            /**
             * Relationships.
             *
             * @example owner,status,address,address.city,address.city.country
             */
            'include' => 'string',

            /**
             * Fields properties
             *
             * @example id,name,slug,owner_id,status_id,created_at,updated_at
             */
            'fields[properties]' => 'string',

            /**
             * Fields owner
             *
             * @example id,name
             */
            'fields[owners]' => 'string',

            /**
             * Fields addresses
             *
             * @example id,city_id,address_line,created_at,updated_at
             */
            'fields[addresses]' => 'string',
        ]);

        $propertyItem = QueryBuilder::for(Property::class)
            ->select('id', 'name', 'slug', 'status_id', 'owner_id')
            ->allowedFields([
                'id',
                'name',
                'slug',
                'owner_id',
                'status_id',
                'created_at',
                'updated_at',
                'owners.id',
                'owners.name',
                'owners.email',
                'statuses.id',
                'statuses.name',
                'addresses.id',
                'addresses.city_id',
                'addresses.address_line',
                'addresses.property_id',
            ])
            ->allowedIncludes(['owner', 'address', 'address.city', 'address.city.country'])
            ->findOrFail($property);

        return PropertyResource::make($propertyItem)->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Update property
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdatePropertyRequest $request, Property $property, PropertyRepository $propertyRepository)
    {
        Gate::authorize('update', $property);
        $propertyRepository->updateRequestProperty(property: $property);

        return response([])->setStatusCode(Response::HTTP_NO_CONTENT);
    }

    /**
     * Delete property
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Property $property)
    {
        Gate::authorize('delete', $property);
        $property->delete();

        return response([])->setStatusCode(Response::HTTP_NO_CONTENT);
    }
}
