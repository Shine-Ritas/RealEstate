<?php

namespace App\Livewire\SocialLink;

use Livewire\Component;

class SocialLinkFilter extends Component
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
        return view('livewire.social-link.social-link-filter');
    }
}
