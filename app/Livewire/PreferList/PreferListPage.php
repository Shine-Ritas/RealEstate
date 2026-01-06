<?php

namespace App\Livewire\PreferList;

use App\Enums\PreferenceTypeEnum;
use App\Models\Property;
use Livewire\Component;

class PreferListPage extends Component
{

    public string $type = PreferenceTypeEnum::Recommendation->value;

    public  $searchProperties = [];

    public string $search = '';

    public function mount()
    {
        
    }

    public function mutateSearchProperties()
    {
    }


    public function render()
    {
        $topProperties = Property::with('images', 'detail', 'province', 'district', 'subdistrict', 'facilities')
            ->orderBy('view_count', 'desc')
            ->get()
            ->map(function ($property) {
                return [
                    'id' => $property->id,
                    'name' => $property->name,
                    'listing_type' => $property->listing_type,
                    'sale_price' => $property->sale_price,
                    'rent_price' => $property->rent_price,
                    'current_price' => $property->current_price,
                    'view_count' => $property->view_count,
                    'created_at' => $property->created_at?->toISOString(),
                    'images' => $property->images->map(function ($image) {
                        return [
                            'image_url' => $image->image_url,
                            'is_primary' => $image->is_primary,
                        ];
                    })->toArray(),
                    'detail' => $property->detail ? [
                        'land_size_sqm' => $property->detail->land_size_sqm,
                        'bedrooms' => $property->detail->bedrooms,
                        'bathrooms' => $property->detail->bathrooms,
                    ] : null,
                    'province' => $property->province ? [
                        'p_name' => $property->province->p_name,
                    ] : null,
                    'subdistrict' => $property->subdistrict ? [
                        's_name' => $property->subdistrict->s_name,
                    ] : null,
                    'facilities' => $property->facilities->map(function ($facility) {
                        return [
                            'name' => $facility->name,
                        ];
                    })->toArray(),
                ];
            });

        return view('livewire.prefer-list.prefer-list-page', [
            'topProperties' => $topProperties,
        ])->layout('components.layouts.app', [
            'header' => 'Prefer List',
            'subtitle' => 'Manage your prefer list',
        ]);
    }
}
