<?php

namespace App\Models;

use App\Models\Relationships\CountryRelationships;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use CountryRelationships;
}
