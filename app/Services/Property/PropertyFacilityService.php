<?php

namespace App\Services\Property;

use App\Models\Property;

class PropertyFacilityService
{
    public function syncFacilities(Property $property, array $facilities): void
    {
        // add and remove facilities from property_facilities table
        $property->facilities()->sync($facilities);
    }
}
