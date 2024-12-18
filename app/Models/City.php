<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Relationships\CityRelationships;

class City extends Model
{
    use CityRelationships;
}
