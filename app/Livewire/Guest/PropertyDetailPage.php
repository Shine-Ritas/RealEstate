<?php

namespace App\Livewire\Guest;

use Livewire\Component;
use Livewire\Attributes\Layout;

class PropertyDetailPage extends Component
{
    public $name = '';
    public $email = '';
    public $phone = '';
    public $message = '';

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
        'phone' => 'required',
        'message' => 'nullable|string|max:500',
    ];

    public function scheduleViewing()
    {
        $this->validate();

        // TODO: Implement viewing schedule logic
        // For now, just show a success message
        session()->flash('message', 'Viewing request submitted successfully! We will contact you soon.');

        // Reset form
        $this->reset(['name', 'email', 'phone', 'message']);
    }

    #[Layout('components.layouts.guest.guest-layout')]
    public function render()
    {
        return view('livewire.guest.property-detail-page');
    }
}
