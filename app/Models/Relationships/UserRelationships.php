<?php

namespace App\Models\Relationships;

use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Property;

trait UserRelationships 
{
    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }
}
