<?php

namespace App\Livewire\Property;

use App\Enums\ListingTypeEnum;
use App\Enums\OwnerShipTypeEnum;
use App\Enums\PropertyStatusTypeEnum;
use App\Enums\PropertyTypeEnum;
use App\Models\Property;
use App\Services\Property\GeoLocationService;
use App\Services\Property\PropertyFacilityService;
use App\Services\Property\PropertyService;
use App\Traits\Property\PropertyDataTraits;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Joelwmale\LivewireQuill\Traits\HasQuillEditor;
use Livewire\Component;

class Form extends Component
{
    use HasQuillEditor,PropertyDataTraits;

    public ?string $propertyId = null;

    // model prperties
    public string $name = '';

    public string $description = '';

    public string $zipcode = '';

    public ?float $rentPrice;

    public ?float $salePrice;

    public string $currency = 'THB';

    public ?float $latitude;

    public ?float $longitude;

    public ?string $address = '';

    public ?string $propertyType = null;

    public ?string $listingType = null;

    // property Detail properties
    public ?int $floor;

    public ?int $unitNumber;

    public ?int $bedrooms;

    public ?int $bathrooms;

    public ?float $sizeSqm;

    public ?float $landSizeSqm;

    public ?int $yearBuilt;

    public ?string $ownership = '';

    public ?string $number;

    public ?string $propertyStatus;

    // data collection

    // selected section

    public mixed $selectedFacilities = [];

    public ?string $selectedProvince = null;

    public ?string $selectedDistrict = null;

    public ?string $selectedSubDistrict = null;

    public string $status = 'active';

    public function mount(?Property $property = null): void
    {

        $this->loadAll();
        if ($property) {
            $property->load('detail', 'province', 'district', 'subdistrict');
            $this->loadForEdit($property->province->p_code, $property->district->d_code);
            $this->propertyId = $property->id;
            $this->name = $property->name;
            $this->description = $property->description;
            $this->status = $property->status ?? 'active';
            $this->selectedFacilities = $property->facilities->pluck('id')->toArray();
            $this->selectedProvince = $property->province->p_code;
            $this->selectedDistrict = $property->district->d_code;
            $this->selectedSubDistrict = $property->subdistrict->s_code;
            $this->zipcode = $property->zipcode;
            $this->latitude = $property->latitude;
            $this->longitude = $property->longitude;
            $this->address = $property->address;
            $this->propertyType = $property->property_type;
            $this->listingType = $property->listing_type;
            $this->rentPrice = $property->rent_price;
            $this->salePrice = $property->sale_price;
            $this->floor = $property->detail?->floor;
            $this->unitNumber = $property->detail?->unit_number;
            $this->bedrooms = $property->detail?->bedrooms;
            $this->bathrooms = $property->detail?->bathrooms;
            $this->sizeSqm = $property->detail?->size_sqm;
            $this->landSizeSqm = $property->detail?->land_size_sqm;
            $this->yearBuilt = $property->detail?->year_built;
            $this->number = $property->detail?->number;
            $this->ownership = $property->detail?->ownership;
            $this->propertyStatus = $property->detail?->status;
        } else {

        }

    }

    public function contentChanged($editorId, $content)
    {
        $this->description = $content;
    }

    public function updatedSelectedProvince($value): void
    {
        $this->districts = convert_to_dropdown(GeoLocationService::getDistrctByProvince($value), 'd_name', 'd_code');
        $this->subDistricts = [];
        $this->dispatch('district-options-updated', options: $this->districts);
        $this->dispatch('sub-district-options-updated', options: $this->subDistricts);
    }

    public function updatedSelectedDistrict($value): void
    {
        $this->subDistricts = convert_to_dropdown(GeoLocationService::getSubdistrictByDistrict($value), 's_name', 's_code');
        $this->dispatch('sub-district-options-updated', options: $this->subDistricts);
    }

    public function updatedSelectedSubDistrict($value): void
    {
        $this->zipcode = GeoLocationService::getZipcodeBySubdistrict($value);
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'address' => ['nullable', 'string', 'max:255'],
            'zipcode' => ['required', 'string', 'max:10'],
            'selectedDistrict' => ['required', 'exists:districts,d_code'],
            'selectedProvince' => ['required', 'exists:provinces,p_code'],
            'selectedSubDistrict' => ['required', 'exists:subdistricts,s_code'],
            'floor' => ['required', 'integer', 'min:1'],
            'unitNumber' => ['required', 'int', 'max:255'],
            'number' => ['required', 'string', 'max:255'],
            'bedrooms' => ['required', 'integer', 'min:1'],
            'bathrooms' => ['required', 'integer', 'min:1'],
            'sizeSqm' => ['required', 'numeric', 'min:0'],
            'landSizeSqm' => ['required', 'numeric', 'min:0'],
            'yearBuilt' => ['required', 'integer', 'min:1900', 'max:'.(date('Y') + 10)],
            'ownership' => ['required', 'in:'.OwnerShipTypeEnum::commaSeparatedValues()],
            'propertyStatus' => ['required', 'in:'.PropertyStatusTypeEnum::commaSeparatedValues()],
            'propertyType' => ['required', 'in:'.PropertyTypeEnum::commaSeparatedValues()],
            'listingType' => ['required', 'in:'.ListingTypeEnum::commaSeparatedValues()],
        ];
    }

    public function save(): void
    {

        $this->validate();

        $propertyData = [
            'name' => $this->name,
            'description' => $this->description,
            'property_type' => $this->propertyType,
            'listing_type' => $this->listingType,
            'rent_price' => $this->rentPrice,
            'sale_price' => $this->salePrice,
            'currency' => $this->currency,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'address' => $this->address,
            'd_code' => $this->selectedDistrict,
            'p_code' => $this->selectedProvince,
            's_code' => $this->selectedSubDistrict,
            'zipcode' => $this->zipcode,
        ];

        DB::transaction(function () use ($propertyData) {
            if ($this->propertyId) {
                $property = Property::findOrFail($this->propertyId);
                $property->update($propertyData);
                session()->flash('success', 'Project updated successfully.');
            } else {
                $property = Property::create($propertyData);
                session()->flash('success', 'Project created successfully.');
            }

            (new PropertyService)->savePropertyDetail($property, [
                'floor' => $this->floor,
                'unit_number' => $this->unitNumber,
                'bedrooms' => $this->bedrooms,
                'bathrooms' => $this->bathrooms,
                'size_sqm' => $this->sizeSqm,
                'land_size_sqm' => $this->landSizeSqm,
                'number' => $this->number,
                'ownership' => $this->ownership,
                'status' => $this->propertyStatus,
                'year_built' => $this->yearBuilt,
            ]);
            (new PropertyFacilityService)->syncFacilities($property, $this->selectedFacilities);
        });

        $this->redirect(route('properties.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.property.form', [
        ])->layout('components.layouts.app', [
            'header' => $this->propertyId ? 'Modify Property' : 'Upload New Property',
            'subtitle' => $this->propertyId ? 'Update project information' : 'Add a new project to the system',
        ])->with('propertyId', $this->propertyId);
    }

    public function toggleSelectedFacility(int $facilityId): void
    {
        if (in_array($facilityId, $this->selectedFacilities)) {
            $this->selectedFacilities = array_diff($this->selectedFacilities, [$facilityId]);
        } else {
            $this->selectedFacilities[] = $facilityId;
        }
    }
}
