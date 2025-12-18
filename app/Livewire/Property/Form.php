<?php

namespace App\Livewire\Property;

use App\Enums\FurnishedTypeEnum;
use App\Enums\ListingTypeEnum;
use App\Enums\OwnerShipTypeEnum;
use App\Enums\PropertyStatusTypeEnum;
use App\Enums\PropertyTypeEnum;
use App\Models\District;
use App\Models\Facility;
use App\Models\Property;
use App\Models\Province;
use App\Services\Property\GeoLocationService;
use App\Services\Property\PropertyFacilityService;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Joelwmale\LivewireQuill\Traits\HasQuillEditor;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Traits\Property\PropertyDataTraits;
class Form extends Component
{

    use HasQuillEditor,PropertyDataTraits;

    public ?string $projectId = null;

    // model prperties
    public string $name = '';
    public string $description = '';
    public string $zipcode = '';

    public float $currentPrice ;
    public float $rentPrice ;
    public float $salePrice ;
    public string $currency = 'THB';

    public float $latitude ;
    public float $longitude ;

    public string $address = '';

    public ?string $propertyType = null;
    public ?string $listingType = null;

    // property Detail properties
    public int $floor;
    public string $unitNumber = '';
    public int $bedrooms ;
    public int $bathrooms;
    public float $sizeSqm;
    public float $landSizeSqm;
    public int $yearBuilt ;
    public string $ownership = '';
    public string $furnished;
    public string $propertyStatus;

    // data collection
 
    // selected section

    public mixed $selectedFacilities = [];
    public ?string $selectedProvince = null;
    public ?string $selectedDistrict = null;

    public ?string $selectedSubDistrict = null;

    public string $status = 'active';


    public function mount(?Property $project = null): void
    {

        $this->loadAll();
        if ($project) {
            $this->projectId = $project->id;
            $this->name = $project->name;
            $this->status = $project->status ?? 'active';
            $this->selectedFacilities = $project->facilities->pluck('id')->toArray();
        }

        // set fake validation eeror

        $this->name = 'Knightsbridge Space Ratchayothin';
        $this->description = 'Knightsbridge Space Ratchayothin is a new project in Bangkok, Thailand. It is a mixed-use development with a mix of residential, commercial, and retail space.';
        $this->latitude = 13.799874772331705;
        $this->longitude = 100.55048350859911;
        $this->address = '123 Bangkok, Thailand';
        $this->propertyType = PropertyTypeEnum::Condo->value;
        $this->listingType = ListingTypeEnum::Rent->value;
        $this->currentPrice = 1000000;
        $this->rentPrice = 10000;
        $this->salePrice = 1000000;

        $this->floor = 10;
        $this->unitNumber = '15/230';
        $this->bedrooms = 2 ;
        $this->bathrooms = 1;
        $this->sizeSqm = 100;
        $this->landSizeSqm = 100;
        $this->yearBuilt = 2024;
        $this->ownership = OwnerShipTypeEnum::Freehold->value;
        $this->furnished = FurnishedTypeEnum::Fully->value;
        $this->propertyStatus = PropertyStatusTypeEnum::Active->value;


    }

    public function updatedSelectedProvince($value): void
    {
        $this->districts = convert_to_dropdown(GeoLocationService::getDistrctByProvince($value), 'd_name', 'd_code');
        $this->dispatch('district-options-updated', options: $this->districts);
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
            'unitNumber' => ['required', 'string', 'max:255'],
            'bedrooms' => ['required', 'integer', 'min:1'],
            'bathrooms' => ['required', 'integer', 'min:1'],
            'sizeSqm' => ['required', 'numeric', 'min:0'],
            'landSizeSqm' => ['required', 'numeric', 'min:0'],
            'yearBuilt' => ['required', 'integer', 'min:1900', 'max:'.(date('Y') + 10)],
            'ownership' => ['required', 'in:'.OwnerShipTypeEnum::commaSeparatedValues()],
            'furnished' => ['required', 'in:'.FurnishedTypeEnum::commaSeparatedValues()],
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
            'current_price' => $this->currentPrice,
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
            if ($this->projectId) {
                $property = Property::findOrFail($this->projectId);
                $property->update($propertyData);
                session()->flash('message', 'Project updated successfully.');
            } else {
                $property = Property::create($propertyData);
                session()->flash('message', 'Project created successfully.');
            }

            (new PropertyFacilityService())->syncFacilities($property, $this->selectedFacilities);
        });

        $this->redirect(route('projects.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.property.form', [
        ])->layout('components.layouts.app', [
            'header' => $this->projectId ? 'Modify Property' : 'Upload New Property',
            'subtitle' => $this->projectId ? 'Update project information' : 'Add a new project to the system',
        ]);
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
