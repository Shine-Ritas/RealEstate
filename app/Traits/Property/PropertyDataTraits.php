<?php

namespace App\Traits\Property;

use App\Enums\FurnishedTypeEnum;
use App\Enums\ListingTypeEnum;
use App\Enums\OwnerShipTypeEnum;
use App\Enums\PropertyStatusTypeEnum;
use App\Enums\PropertyTypeEnum;
use App\Models\Facility;
use App\Services\Property\GeoLocationService;

trait PropertyDataTraits
{
    public mixed $facilities ;
    public mixed $propertyTypes;
    public mixed $provinces;
    public mixed $districts = null;
    public mixed $subDistricts = null;
    public mixed $listingTypes ;
    public mixed $furnishesTypes ;
    public mixed $ownershipTypes;
    public mixed $propertyStatusTypes;
    public function loadAll()
    {
        $this->propertyTypes = PropertyTypeEnum::dropdown();
        $this->listingTypes = ListingTypeEnum::dropdown();
        $this->provinces = convert_to_dropdown(GeoLocationService::getProvinces(), 'p_name', 'p_code');
        $this->facilities = Facility::where('status', 'active')->get();
        $this->furnishesTypes = FurnishedTypeEnum::dropdown();
        $this->ownershipTypes = OwnerShipTypeEnum::dropdown();
        $this->propertyStatusTypes = PropertyStatusTypeEnum::dropdown();
    }


}
