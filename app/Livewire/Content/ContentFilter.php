<?php

namespace App\Livewire\Content;

use Artisan;
use Livewire\Component;

class ContentFilter extends Component
{
    public string $search = '';

    public function updatedSearch()
    {
        $this->emitEvent();
    }

    public function emitEvent()
    {
        $this->dispatch('update-filter', [
            'search' => $this->search,
        ]);
    }

    public function publish()
    {
        Artisan::call('export:language');
        $this->dispatch('notify', [
            'variant' => 'success',
            'title' => 'success',
            'message' => 'Published Successfully !',
        ]);

    }

    public function render()
    {
        return view('livewire.content.content-filter');
    }
}
