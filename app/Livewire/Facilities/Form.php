<?php

namespace App\Livewire\Facilities;

use App\Models\Facility;
use Livewire\Component;

class Form extends Component
{
    public bool $showModal = false;

    public ?int $facilityId = null;

    public string $name = '';

    public string $icon = '';

    public ?string $description = '';

    public string $status = 'active';

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:facilities,name,'.$this->facilityId],
            'icon' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'status' => ['required', 'in:active,inactive'],
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'The facility name is required.',
            'name.unique' => 'A facility with this name already exists.',
            'icon.required' => 'The icon name is required.',
            'status.required' => 'The status is required.',
        ];
    }

    protected $listeners = ['open-facility-form' => 'handleOpenModal'];

    public function handleOpenModal($data = []): void
    {
        $facilityId = $data['facilityId'] ?? null;
        $this->openModal($facilityId);
    }

    public function openModal(?int $facilityId = null): void
    {
        $this->facilityId = $facilityId;

        if ($facilityId) {
            $facility = Facility::findOrFail($facilityId);
            $this->name = $facility->name;
            $this->icon = $facility->icon;
            $this->description = $facility->description ?? '';
            $this->status = $facility->status;
        } else {
            $this->reset(['name', 'icon', 'description', 'status']);
            $this->status = 'active';
        }

        $this->resetValidation();
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset(['facilityId', 'name', 'icon', 'description', 'status']);
        $this->resetValidation();
    }

    public function save(): void
    {
        $this->validate();

        if ($this->facilityId) {
            $facility = Facility::findOrFail($this->facilityId);
            $facility->update([
                'name' => $this->name,
                'icon' => $this->icon,
                'description' => $this->description,
                'status' => $this->status,
            ]);
            session()->flash('message', 'Facility updated successfully.');
        } else {
            Facility::create([
                'name' => $this->name,
                'icon' => $this->icon,
                'description' => $this->description,
                'status' => $this->status,
            ]);
            session()->flash('message', 'Facility created successfully.');
        }

        $this->closeModal();
        $this->dispatch('facility-saved');
    }

    public function render()
    {
        return view('livewire.facilities.form');
    }
}
