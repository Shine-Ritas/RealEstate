<?php

namespace App\Livewire\Facilities;

use App\Models\Facility;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public bool $showDeleteModal = false;

    public ?Facility $facilityToDelete = null;

    public function openDeleteModal(int $facilityId): void
    {
        $this->facilityToDelete = Facility::findOrFail($facilityId);
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal(): void
    {
        $this->showDeleteModal = false;
        $this->facilityToDelete = null;
    }

    public function deleteFacility(): void
    {
        if ($this->facilityToDelete) {
            $this->facilityToDelete->delete();
            $this->closeDeleteModal();
            session()->flash('message', 'Facility deleted successfully.');
        }
    }

    protected $listeners = ['facility-saved' => '$refresh'];

    public function render()
    {
        $facilities = Facility::orderBy('name')
            ->paginate(12);

        return view('livewire.facilities.index', [
            'facilities' => $facilities,
        ]);
    }
}
