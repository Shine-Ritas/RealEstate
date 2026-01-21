<?php

namespace App\Livewire\Property;

use App\Traits\Property\PropertyDataTraits;
use Livewire\Component;

class PropertyFilter extends Component
{
    use PropertyDataTraits;

    public string $search = '' ;

    public string $selectedPropertyStatus = '';

    public function updatedSelectedPropertyStatus(){
        $this->emitEvent();
    }

    public function mount(){
        $this->loadAll();
    }

    public function updatedSearch(){
        $this->emitEvent();
    }

    public function emitEvent()
    {
         $this->dispatch('update-filter',[
            'search' => $this->search,
            'selectedPropertyStatus' => $this->selectedPropertyStatus,
        ]);
    }


    public function render()
    {
        return view('livewire.property.property-filter');
    }
}
