<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Relationships\CountryRelationships;

class Country extends Model
{
    use CountryRelationships;
}
