<?php

namespace App\Models\Relationships;

use App\Models\Property;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait UserRelationships
{
    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }
}
