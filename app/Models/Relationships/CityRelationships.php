<?php

namespace App\Models\Relationships;

use App\Models\Country;
use App\Models\PropertyAddress;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait CityRelationships
{
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function propertyAddresses(): HasMany
    {
        return $this->hasMany(PropertyAddress::class);
    }
}
