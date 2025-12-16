<?php

namespace App\Livewire\Property;

use App\Enums\ListingTypeEnum;
use App\Enums\PropertyTypeEnum;
use App\Models\District;
use App\Models\Facility;
use App\Models\Property;
use App\Models\Province;
use App\Services\Property\GeoLocationService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Joelwmale\LivewireQuill\Traits\HasQuillEditor;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Form extends Component
{

    use HasQuillEditor;
    public ?string $projectId = null;

    // model prperties
    public string $name = '';
    public string $description = '';
    public string $zipcode = '';


    public ?string $propertyType = null;
    public ?string $listingType = null;


    // data collection
    public Collection $facilities ;

    public array $propertyTypes;
    public mixed $provinces;
    public mixed $districts = null;
    public mixed $subDistricts = null;
    public array $listingTypes ;

    // selected section

    public mixed $selectedFacilities = [];
    public ?string $selectedProvince = null;
    public ?string $selectedDistrict = null;

    public ?string $selectedSubDistrict = null;

    public string $status = 'active';


    public function mount(?Property $project = null): void
    {

        if ($project) {
            $this->projectId = $project->id;
            $this->name = $project->name;
            $this->status = $project->status ?? 'active';
            $this->selectedFacilities = $project->facilities->pluck('id')->toArray();
        }
        $this->propertyTypes = PropertyTypeEnum::dropdown();

        $this->listingTypes = ListingTypeEnum::dropdown();
        $this->provinces = convert_to_dropdown(GeoLocationService::getProvinces(), 'p_name', 'p_code');

        $this->facilities = Facility::where('status', 'active')->get();
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
            'slug' => ['required', 'string', 'max:255', 'unique:projects,slug,'.$this->projectId],
            'description' => ['nullable', 'string'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'address' => ['nullable', 'string', 'max:255'],
            'districtId' => ['required', 'exists:districts,id'],
            'provinceId' => ['required', 'exists:provinces,id'],
            'totalFloors' => ['nullable', 'integer', 'min:1'],
            'totalUnits' => ['nullable', 'integer', 'min:1'],
            'yearCompleted' => ['nullable', 'integer', 'min:1900', 'max:'.(date('Y') + 10)],
            'status' => ['required', 'in:active,inactive'],
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'The project name is required.',
            'slug.required' => 'The slug is required.',
            'slug.unique' => 'A project with this slug already exists.',
            'districtId.required' => 'Please select a district.',
            'districtId.exists' => 'The selected district is invalid.',
            'provinceId.required' => 'Please select a province.',
            'provinceId.exists' => 'The selected province is invalid.',
            'latitude.numeric' => 'Latitude must be a valid number.',
            'latitude.between' => 'Latitude must be between -90 and 90.',
            'longitude.numeric' => 'Longitude must be a valid number.',
            'longitude.between' => 'Longitude must be between -180 and 180.',
            'totalFloors.integer' => 'Total floors must be a valid number.',
            'totalFloors.min' => 'Total floors must be at least 1.',
            'totalUnits.integer' => 'Total units must be a valid number.',
            'totalUnits.min' => 'Total units must be at least 1.',
            'yearCompleted.integer' => 'Year completed must be a valid year.',
            'yearCompleted.min' => 'Year completed must be at least 1900.',
            'yearCompleted.max' => 'Year completed cannot be more than '.(date('Y') + 10).'.',
            'status.required' => 'The status is required.',
        ];
    }

    public function save(): void
    {
        $this->validate();

        $data = [
           
        ];

        if ($this->projectId) {
            $project = Property::findOrFail($this->projectId);
            $project->update($data);
            session()->flash('message', 'Project updated successfully.');
        } else {
            Property::create($data);
            session()->flash('message', 'Project created successfully.');
        }

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
