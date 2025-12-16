<?php

namespace App\Livewire\Property;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.property.index')->layout('components.layouts.app', [
            'header' => "Property",
            'subtitle' => 'Manage your Property',
        ]);
    }
}
