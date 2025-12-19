<?php

namespace App\Services\Property;

use App\Models\Property;

class PropertyService
{
    public function savePropertyDetail(Property $property,array $data){
        $property->detail()->updateOrCreate([
            'property_id' => $property->id
        ],$data);
    }
}
