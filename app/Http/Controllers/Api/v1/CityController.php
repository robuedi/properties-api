<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\GenericListingRequest;
use App\Http\Resources\v1\CityResource;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CityController extends Controller
{
    /**
     * List cities.
     *
     * @unauthenticated
     */
    public function index(GenericListingRequest $request)
    {
        $request->validate([

            /**
             * Fields cities
             *
             * @example id,name,country_id
             */
            'fields[cities]' => 'string',

            /**
             * Filter name
             *
             * @example Iasi
             */
            'filter[name]' => 'string',

            /**
             * Filter name
             *
             * @example 182
             */
            'filter[country_id]' => 'int',

            'sort' => 'in:name,-name',
        ]);

        $cities = QueryBuilder::for(City::class)
            ->select('id', 'name', 'country_id')
            ->allowedFields([
                'id',
                'name',
                'country_id',
            ])
            ->defaultSort('name')
            ->allowedFilters(['name', AllowedFilter::exact('country_id')])
            ->allowedSorts('name', '-name')
            ->paginate(request('per_page', 15))
            ->appends(request()->query());

        return CityResource::collection($cities)->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Show city.
     *
     * @unauthenticated
     */
    public function show(Request $request, int $city)
    {
        $request->validate([
            /**
             * Relationships.
             *
             * @example country
             */
            'include' => 'string',

            /**
             * Fields countries
             *
             * @example id,name,code
             */
            'fields[countries]' => 'string',

            /**
             * Fields cities
             *
             * @example id,name,country_id
             */
            'fields[cities]' => 'string',
        ]);

        $cityItem = QueryBuilder::for(City::class)
            ->select('id', 'country_id', 'name')
            ->allowedFields([
                'id',
                'name',
                'country_id',
                'countries.id',
                'countries.name',
                'countries.code',
            ])
            ->allowedIncludes(['country'])
            ->findOrFail($city);

        return CityResource::make($cityItem)->response()->setStatusCode(Response::HTTP_OK);
    }
}
