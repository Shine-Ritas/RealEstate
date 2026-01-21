<?php

namespace App\Livewire\Guest;

use App\Models\Property;
use Livewire\Component;

class PropertyMap extends Component
{
    public $properties = [];

    public function mount(): void
    {
        $this->loadProperties();
    }

    public function loadProperties(?float $north = null, ?float $south = null, ?float $east = null, ?float $west = null): void
    {
        $query = Property::with(['images', 'detail', 'province', 'subdistrict'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude');

        // Filter by bounds if provided
        if ($north !== null && $south !== null && $east !== null && $west !== null) {
            $query->whereBetween('latitude', [$south, $north])
                ->whereBetween('longitude', [$west, $east]);
        }

        $properties = $query->get();

        $this->properties = $properties->map(function ($property) {
            $image = asset('assets/no_image.jpg');
            if ($property->has_image) {
                try {
                    $primaryImage = $property->images()->where('is_primary', true)->first();
                    $image = $primaryImage?->image_url ?? $property->images()->first()?->image_url ?? $image;
                } catch (\Exception $e) {
                    // Fallback to no image
                }
            }

            return [
                'id' => $property->id,
                'lat' => (float) $property->latitude,
                'lng' => (float) $property->longitude,
                'name' => $property->name,
                'price' => $this->getPrice($property),
                'image' => $image,
                'bed' => $property->detail?->bedrooms ?? 0,
                'bath' => $property->detail?->bathrooms ?? 0,
                'size' => $property->detail?->size_sqm ?? 0,
            ];
        })->toArray();
    }

    private function getPrice(Property $property): float
    {
        return match ($property->listing_type) {
            'sale' => (float) ($property->sale_price ?? 0),
            'rent' => (float) ($property->rent_price ?? 0),
            'both' => (float) ($property->current_price ?? 0),
            default => 0,
        };
    }

    public function render()
    {
        return view('livewire.guest.property-map', [
            'propertiesData' => $this->properties,
        ]);
    }
}
