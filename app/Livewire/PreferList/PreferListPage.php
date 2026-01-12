<?php

namespace App\Livewire\PreferList;

use App\Enums\PreferenceTypeEnum;
use App\Models\Property;
use Livewire\Component;

class PreferListPage extends Component
{
    public string $type = PreferenceTypeEnum::Recommendation->value;
    public $searchProperties = [];
    public string $search = '';

    public function mount()
    {
        $this->loadSearchProperties();
    }

    public function updatedSearch()
    {
        $this->loadSearchProperties();
        $this->dispatch('refreshSwiper');
    }

    public function loadSearchProperties()
    {
        $this->searchProperties = Property::with('images', 'detail', 'province', 'district', 'subdistrict', 'facilities')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->withExists([
                'preferences as has_preference' => function ($q) {
                    $q->where('type', $this->type);
                }
            ])
            ->orderBy('view_count', 'desc')
            ->get();
    }

    public function render()
    {
        $topProperties = Property::with('images', 'detail', 'province', 'district', 'subdistrict', 'facilities')
            ->withExists([
                'preferences as has_preference' => function ($q) {
                    $q->where('type', $this->type);
                }
            ])
            ->orderBy('view_count', 'desc')
            ->limit(12)
            ->get();

        return view('livewire.prefer-list.prefer-list-page', [
            'topProperties' => $topProperties,
            'searchProperties' => $this->searchProperties,
        ])->layout('components.layouts.app', [
            'header' => 'Prefer List',
            'subtitle' => 'Manage your prefer list',
        ]);
    }
}