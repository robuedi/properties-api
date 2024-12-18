<?php

namespace App\Models\Relationships;

use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\City;

trait CountryRelationships 
{
    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }
}
