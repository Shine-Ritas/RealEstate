<?php

namespace App\Livewire\Property;

use App\Models\Property;
use App\Services\Property\PropertyService;
use App\Traits\BaseTrait;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination,BaseTrait;

    public string $search = '';


    public function render()
    {
        return view('livewire.property.index',[
            'properties' => Property::with('images','detail','province','district','subdistrict')->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('name')
            ->paginate(12),
        ])->layout('components.layouts.app', [
            'header' => "Property",
            'subtitle' => 'Manage your Property',
        ]);
    }

    public function deleteProperty(): void
    {
        (new PropertyService())->deleteProperty($this->toDelete);
        $this->dispatch('notify', [
            'variant' => 'success',
            'title' => 'Success',
            'message' => 'Property Deleted Successfully.',
        ]);
        $this->reset('toDelete');
        $this->resetPage();
    }
}
