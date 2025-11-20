<?php

namespace App\Livewire\Guest;

use Livewire\Attributes\Layout;
use Livewire\Component;

class HomePage extends Component
{
    #[Layout('components.layouts.guest.guest-layout')]
    public function render()
    {
        return view('livewire.guest.home-page');
    }
}
