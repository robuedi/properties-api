<?php

namespace App\Observers;

use App\Models\Property;
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
}
