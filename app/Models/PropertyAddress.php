<?php

namespace App\Models;

use App\Models\Relationships\PropertyAddressRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyAddress extends Model
{
    use HasFactory, PropertyAddressRelationships;

    protected $table = 'property_addresses';
}
