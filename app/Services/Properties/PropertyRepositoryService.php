<?php

namespace App\Services\Properties;

use App\Models\Property;

class PropertyRepositoryService
{
    public function authUserRequestCreateProperty()
    {
        return Property::create([...request()->only('name', 'status_id'), ...['owner_id' => auth()->user()->id]]);
    }
}
