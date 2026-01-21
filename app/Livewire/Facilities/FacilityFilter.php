<?php

namespace App\Livewire\Facilities;

use Livewire\Component;

class FacilityFilter extends Component
{
     public string $search = '' ;

    public function updatedSearch(){
        $this->emitEvent();
    }

    public function emitEvent()
    {
         $this->dispatch('update-filter',[
            'search' => $this->search,
        ]);
    }

    
    public function render()
    {
        return view('livewire.facilities.facility-filter');
    }
}
