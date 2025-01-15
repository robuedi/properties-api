<?php

namespace App\Models\Relationships;

use App\Models\City;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait CountryRelationships
{
    public function cities(): HasMany
    {
        return $this->hasMany(City::class, 'country_id', 'id');
    }
}
