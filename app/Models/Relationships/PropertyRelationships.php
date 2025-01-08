<?php

namespace App\Models\Relationships;

use App\Models\PropertyAddress;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait PropertyRelationships
{
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function address(): HasOne
    {
        return $this->hasOne(PropertyAddress::class);
    }
}
