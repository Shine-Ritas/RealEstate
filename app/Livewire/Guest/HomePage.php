<?php

namespace App\Livewire\Guest;

use Livewire\Component;
use Livewire\Attributes\Layout;
class HomePage extends Component
{

    #[Layout('components.layouts.guest.guest-layout')]
    public function render()
    {
        return view('livewire.guest.home-page');
    }
}
