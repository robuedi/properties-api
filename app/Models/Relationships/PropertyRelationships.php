<?php

namespace App\Models\Relationships;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\User;
use App\Models\PropertyAddress;

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
