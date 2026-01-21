<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PropertyMapController extends Controller
{
    public function getPropertiesByBounds(Request $request): JsonResponse
    {
        $north = (float) $request->input('north');
        $south = (float) $request->input('south');
        $east = (float) $request->input('east');
        $west = (float) $request->input('west');

        if (! $north || ! $south || ! $east || ! $west) {
            return response()->json(['error' => 'Invalid bounds'], 400);
        }

        $query = Property::with(['images', 'detail', 'province', 'subdistrict'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->whereBetween('latitude', [$south, $north])
            ->whereBetween('longitude', [$west, $east]);

        $properties = $query->get();

        $data = $properties->map(function ($property) {
            $image = asset('assets/no_image.jpg');
            if ($property->has_image) {
                try {
                    $primaryImage = $property->images()->where('is_primary', true)->first();
                    $image = $primaryImage?->image_url ?? $property->images()->first()?->image_url ?? $image;
                } catch (\Exception $e) {
                    // Fallback to no image
                }
            }

            $price = match ($property->listing_type) {
                'sale' => (float) ($property->sale_price ?? 0),
                'rent' => (float) ($property->rent_price ?? 0),
                'both' => (float) ($property->current_price ?? 0),
                default => 0,
            };

            return [
                'id' => $property->id,
                'lat' => (float) $property->latitude,
                'lng' => (float) $property->longitude,
                'name' => $property->name,
                'price' => $price,
                'image' => $image,
                'bed' => $property->detail?->bedrooms ?? 0,
                'bath' => $property->detail?->bathrooms ?? 0,
                'size' => $property->detail?->size_sqm ?? 0,
            ];
        })->toArray();

        return response()->json($data);
    }
}
