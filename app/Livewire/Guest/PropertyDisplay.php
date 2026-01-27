<?php

namespace App\Livewire\Guest;

use App\Models\Property;
use Livewire\Component;

class PropertyDisplay extends Component
{


    public function getBasePropertyModel($limit = 4)
    {
        return Property::with('images','detail','province','district','subdistrict')
        ->inRandomOrder()
        ->paginate(4);
    }

    public function render()
    {
        return view('livewire.guest.property-display',[
            'near_mrt' =>  $this->getBasePropertyModel(),
            'near_school' =>  $this->getBasePropertyModel(),
            'luxury_estates' =>  $this->getBasePropertyModel(),
            'latest_projects' =>  $this->getBasePropertyModel(),
        ]);
    }
}
