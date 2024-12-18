<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Relationships\PropertyRelationships;

class Property extends Model
{
    use HasFactory, PropertyRelationships;
}
