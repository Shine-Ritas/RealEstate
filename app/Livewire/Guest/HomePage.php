<?php

namespace App\Livewire\Guest;

use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class HomePage extends Component
{
    #[Layout('components.layouts.guest.guest-layout')]
    public function render(): View
    {
        return view('livewire.guest.home-page');
    }
}
