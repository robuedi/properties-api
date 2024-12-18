<?php

namespace App\Models\Relationships;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Country;
use App\Models\PropertyAddress;

trait CityRelationships 
{
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function propertyAddresses(): HasMany
    {
        return $this->hasMany(PropertyAddress::class);
    }
}
