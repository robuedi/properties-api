<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Relationships\PropertyStatusRelationships;

class PropertyStatus extends Model
{
    use PropertyStatusRelationships;
}
