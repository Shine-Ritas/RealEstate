<?php

namespace App\Livewire\Guest;

use Livewire\Attributes\Layout;
use Livewire\Component;

class PropertyFilterPage extends Component
{
    public $properties;

    public $filterState = [];

    public function mount() {}

    #[Layout('components.layouts.guest.guest-layout')]
    public function render()
    {
        return view('livewire.guest.property-filter-page');
    }
}
