<?php

namespace App\Repositories;

use App\Models\Property;
use Illuminate\Http\Response;

class PropertyAddressRepository
{

    public function createPropertyAddressRequest(Property &$property): void
    {
        //load address
        $property->load('address');

        //check if address exists
        if ($property->address) {
            abort(Response::HTTP_CONFLICT, 'An address already exists for this property.');
        }

        $property->address()->create(request()->only('city_id', 'address_line'));
    }

    public function updatePropertyAddressRequest(Property &$property): void
    {
        //load address
        $property->load('address');

        //check if address exists
        if(!$property->address)
        {
            abort(404);
        }
        $property->address->update(request()->only('city_id', 'address_line'));
    }

    public function deletePropertyAddressRequest(Property &$property): void
    {
        //load address
        $property->load('address');

        //check if address exists
        if(!$property->address)
        {
            abort(404);
        }

        $property->address->delete();
    }
}
