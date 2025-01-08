<?php

namespace App\Models\Relationships;

use App\Models\City;
use App\Models\Property;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
