<?php

namespace App\Livewire\Guest;

use Livewire\Attributes\Layout;
use Livewire\Component;

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
        session()->flash('message', __('guest.viewing_request_success'));

        // Reset form
        $this->reset(['name', 'email', 'phone', 'message']);
    }

    #[Layout('components.layouts.guest.guest-layout')]
    public function render()
    {
        return view('livewire.guest.property-detail-page');
    }
}
