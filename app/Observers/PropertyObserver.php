<?php

namespace App\Observers;

use App\Models\Property;
use App\Models\PropertyAddress;
use App\Repositories\PropertyRepository;

class PropertyObserver
{
    public function __construct(protected PropertyRepository $propertyRepository) {}

    /**
     * Handle the Property "saving" event.
     */
    public function saving(Property $property): void
    {
        $this->propertyRepository->setSlugProperty(property: $property);
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(Property $property): void
    {
        // clean the property address, if there was one
        (PropertyAddress::find($property->id))?->delete();
    }
}
