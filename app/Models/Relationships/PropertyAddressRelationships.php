<?php

namespace App\Models\Relationships;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Property;
use App\Models\City;

trait PropertyAddressRelationships 
{
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class, 'property_id', 'id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
}
