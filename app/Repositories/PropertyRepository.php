<?php

namespace App\Repositories;

use App\Enums\PropertyStatus;
use App\Models\Property;
use App\Services\TextUniqueSlugService;

class PropertyRepository
{
    public function setSlugProperty(Property &$property)
    {
        // prevent slug being changed once set
        if ($property->slug) {
            return;
        }

        // set the slug if conditions are meet, aka there is a name and the status is active
        if ($property->name && $property->status_id && $property->status_id->value === PropertyStatus::Active->value) {
            $property->slug = app(TextUniqueSlugService::class)->getSlug($property->name);

            return;
        }
    }

    public function authUserCreateRequestProperty() : Property
    {
        return Property::create([...request()->only('name', 'status_id'), ...['owner_id' => auth()->user()->id]]);
    }

    public function updateRequestProperty(Property $property) : void
    {
        $property->update(request()->only('name', 'status_id'));
    }
}
