<?php

namespace App\Livewire\Content;

use App\Models\Content;
use Livewire\Component;
use Livewire\WithPagination;

class ContentPage extends Component
{
    use WithPagination;

    public string $search = '';

    protected $listeners = ['update-filter' => 'updateFilter'];

    public function mount() {}

    public function updateFilter($data)
    {
        $this->search = $data['search'];
    }

    public function render()
    {
        return view('livewire.content.content-page', [
            'contents' => Content::when($this->search, function ($query) {
                $query->where('label', 'like', '%'.$this->search.'%');
                $query->orWhere('en', 'like', '%'.$this->search.'%');
                $query->orWhere('th', 'like', '%'.$this->search.'%');
                $query->orWhere('my', 'like', '%'.$this->search.'%');
                $query->orWhere('zh', 'like', '%'.$this->search.'%');
            })->paginate(10),
        ])->layout('components.layouts.app', [
            'header' => 'Manage The Contents',
            'subtitle' => 'Modify the contents of the website',
        ]);
    }
}
