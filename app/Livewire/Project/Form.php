<?php

namespace App\Livewire\Project;

use App\Models\Developer;
use App\Models\District;
use App\Models\Facility;
use App\Models\Project;
use App\Models\Province;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Form extends Component
{
    public ?string $projectId = null;

    public string $name = '';

    public string $slug = '';

    public ?string $developerId = null;

    public ?string $description = null;

    public ?string $latitude = null;

    public ?string $longitude = null;

    public ?string $address = null;

    public ?int $districtId = null;

    public ?int $provinceId = null;

    public ?int $totalFloors = null;

    public ?int $totalUnits = null;

    public ?int $yearCompleted = null;

    public Collection $facilities ;

    public mixed $selectedFacilities = [];

    public string $status = 'active';

    public function mount(?Project $project = null): void
    {
        if ($project) {
            $this->projectId = $project->id;
            $this->name = $project->name;
            $this->slug = $project->slug;
            $this->developerId = $project->developer_id;
            $this->description = $project->description;
            $this->latitude = $project->latitude ? (string) $project->latitude : null;
            $this->longitude = $project->longitude ? (string) $project->longitude : null;
            $this->address = $project->address;
            $this->districtId = $project->district_id;
            $this->provinceId = $project->province_id;
            $this->totalFloors = $project->total_floors;
            $this->totalUnits = $project->total_units;
            $this->yearCompleted = $project->year_completed;
            $this->status = $project->status ?? 'active';
            $this->selectedFacilities = $project->facilities->pluck('id')->toArray();
        }

        $this->facilities = Facility::where('status', 'active')->get();
    }

    public function updatedName(): void
    {
        if (! $this->projectId) {
            $this->slug = Str::slug($this->name);
        }
    }

    public function updatedProvinceId(): void
    {
        $this->districtId = null;
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:projects,slug,'.$this->projectId],
            'developerId' => ['nullable', 'exists:developers,ulid'],
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
            'name' => $this->name,
            'slug' => $this->slug,
            'developer_id' => $this->developerId,
            'description' => $this->description,
            'latitude' => $this->latitude ? (float) $this->latitude : null,
            'longitude' => $this->longitude ? (float) $this->longitude : null,
            'address' => $this->address,
            'district_id' => $this->districtId,
            'province_id' => $this->provinceId,
            'total_floors' => $this->totalFloors,
            'total_units' => $this->totalUnits,
            'year_completed' => $this->yearCompleted,
            'status' => $this->status,
        ];

        if ($this->projectId) {
            $project = Project::findOrFail($this->projectId);
            $project->update($data);
            session()->flash('message', 'Project updated successfully.');
        } else {
            Project::create($data);
            session()->flash('message', 'Project created successfully.');
        }

        $this->redirect(route('projects.index'), navigate: true);
    }

    public function render()
    {
        $developers = Developer::orderBy('name')->get();
        $provinces = Province::orderBy('p_name')->get();

        $districts = collect();
        if ($this->provinceId) {
            $province = Province::find($this->provinceId);
            if ($province) {
                $districts = District::where('p_code', $province->p_code)
                    ->orderBy('d_name')
                    ->get();
            }
        }

        return view('livewire.project.form', [
            'developers' => $developers,
            'provinces' => $provinces,
            'districts' => $districts,
        ])->layout('components.layouts.app', [
            'header' => $this->projectId ? 'Edit Project' : 'Create Project',
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
