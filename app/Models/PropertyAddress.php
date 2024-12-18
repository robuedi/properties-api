<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Relationships\PropertyAddressRelationships;

class PropertyAddress extends Model
{
    use HasFactory, PropertyAddressRelationships;
    
    protected $table = 'property_address';
}
