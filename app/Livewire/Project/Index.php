<?php

namespace App\Livewire\Project;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.project.index')->layout('components.layouts.app', [
            'header' => "Project",
            'subtitle' => 'Manage your projects',
        ]);
    }
}
