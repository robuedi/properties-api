<?php

namespace App\Models;

use App\Enums\PropertyStatus;
use App\Models\Relationships\PropertyRelationships;
use App\Observers\PropertyObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([PropertyObserver::class])]
class Property extends Model
{
    use HasFactory, PropertyRelationships;

    public $casts = [
        'status_id' => PropertyStatus::class,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'owner_id',
        'status_id',
        'slug',
    ];
}
