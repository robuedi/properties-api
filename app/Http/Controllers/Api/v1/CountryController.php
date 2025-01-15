<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Requests\GenericListingRequest;
use App\Http\Resources\v1\CountryResource;
use Spatie\QueryBuilder\QueryBuilder; 
use Illuminate\Http\Response;

class CountryController extends Controller
{
    /**
     * List countries
     *
     * @unauthenticated
     */
    public function index(GenericListingRequest $request)
    {
        $request->validate([

            /**
             * Fields countries
             *
             * @example id,name,code
             */
            'fields[countries]' => 'string',

            /**
             * Filter name
             *
             * @example Romania
             */
            'filter[name]' => 'string',


            /**
             * Filter name
             *
             * @example RO
             */
            'filter[code]' => 'string',

            'sort' => 'in:name,-name,code,-code',
        ]);

        $countries = QueryBuilder::for(Country::class)
            ->select('id', 'name')
            ->allowedFields([
                'id',
                'name',
                'code'
            ])
            ->defaultSort('name')
            ->allowedFilters(['name', 'code'])
            ->allowedSorts('name', '-name', 'code', '-code')
            ->paginate(request('per_page', 15))
            ->appends(request()->query());

        return CountryResource::collection($countries)->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Show country
     * 
     * @unauthenticated
     */
    public function show(Request $request, int $country)
    {
        $request->validate([
            /**
             * Relationships.
             *
             * @example cities
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

        $countryItem = QueryBuilder::for(Country::class)
            ->select('id', 'name', 'code')
            ->allowedFields([
                'id',
                'name',
                'code',
                'cities.id',
                'cities.name',
                'cities.country_id'
            ])
            ->allowedIncludes(['cities'])
            ->findOrFail($country);

        return CountryResource::make($countryItem)->response()->setStatusCode(Response::HTTP_OK);
    }
}
