<?php

namespace App\Models;

use App\Models\Relationships\CityRelationships;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use CityRelationships;
}
