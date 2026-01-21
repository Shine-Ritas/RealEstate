<?php

namespace App\Livewire\Facilities;

use App\Models\Facility;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public bool $showDeleteModal = false;

    public ?Facility $facilityToDelete = null;

    protected $listeners = ['facility-saved' => '$refresh', 'update-filter' => 'updateFilter'];

    public function updateFilter($data)
    {
        $this->search = $data['search'];
    }

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
            $this->dispatch('notify', [
                'variant' => 'danger',
                'title' => 'Error',
                'message' => 'Facility Deleted Successfully.',
            ]);
        }
    }


    public function render()
    {
        $facilities = Facility::when($this->search, function ($query) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        })
            ->orderBy('name')
            ->paginate(20);

        return view('livewire.facilities.index', [
            'facilities' => $facilities,
        ])->layout('components.layouts.app', [
            'header' => "Facility Management",
            'subtitle' => 'Manage property facilities and amenities',
        ]);
    }
}
