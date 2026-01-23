<?php

namespace App\Livewire\PreferList;

use App\Enums\PreferenceTypeEnum;
use App\Models\Preference;
use App\Models\Property;
use Livewire\Attributes\Computed;
use Livewire\Component;

class PreferListPage extends Component
{
    public string $type = '';

    public string $search = '';

    protected $listeners = ['search-data' => 'loadSearchProperties'];

    public function mount()
    {
        $this->type = PreferenceTypeEnum::Recommendation->value;
    }

    public function loadSearchProperties($data)
    {
        $this->search = $data['search'];
        $this->type = $data['type'];

        $searched = $this->searchProperties();
        $this->dispatch('search-properties', [$searched]);

    }

    #[Computed]
    public function searchProperties()
    {

        return Property::with('images', 'detail', 'province', 'district', 'subdistrict', 'facilities')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%');
            })
            ->withExists([
                'preferences as has_preference' => function ($q) {
                    $q->where('type', $this->type);
                },
            ])
            ->orderBy('view_count', 'desc')
            ->limit(50)
            ->get();
    }

    public function loadProperites($type)
    {
        return Property::with('images', 'detail', 'province', 'district', 'subdistrict', 'facilities')
            ->withWhereHas('preferences', function ($q) use ($type) {
                $q->where('type', $type);
            })
            ->orderBy('view_count', 'desc')
            ->limit(12)
            ->get();
    }

    public function render()
    {
        return view('livewire.prefer-list.prefer-list-page', [
            'topProperties' => $this->loadProperites(PreferenceTypeEnum::Recommendation->value),
            'popularProperties' => $this->loadProperites(PreferenceTypeEnum::Popular->value),
            'searchProperties' => $this->searchProperties,
        ])->layout('components.layouts.app', [
            'header' => 'Prefer List',
            'subtitle' => 'Manage your prefer list',
        ]);
    }

    public function togglePreference(string $propertyUlid)
    {
        $preference = Preference::where('property_id', $propertyUlid)
            ->where('type', $this->type)
            ->first();

        $action = 'added';

        if ($preference) {
            $preference->delete();
            $action = 'removed';
        } else {
            Preference::create([
                'name' => 'Top Listing',
                'property_id' => $propertyUlid,
                'type' => $this->type,
            ]);
        }

        // Dispatch event for any additional UI updates if needed
        $this->dispatch('preference-updated', [
            'action' => $action,
            'propertyId' => $propertyUlid,
        ]);

        // No need to call loadSearchProperties or dispatch refreshSwiper
        // Alpine will handle the UI update
    }
}
