<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Http\Request;

class PropertyImageController extends Controller
{
    public function upload(Request $request, Property $property)
    {
        $request->validate([
            'images' => 'required|array|min:1',
            'images.*' => 'required|image|max:10240', // 10MB max
        ]);

        $storagePath = "property/{$property->id}/images";
        $hasExistingImages = $property->images()->exists();
        $uploadedCount = 0;

        foreach ($request->file('images') as $index => $image) {
            try {
                $filename = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs($storagePath, $filename, 'public');

                PropertyImage::create([
                    'property_id' => $property->id,
                    'image_path' => $path,
                    'is_primary' => !$hasExistingImages && $index === 0,
                ]);

                $uploadedCount++;

                if (!$hasExistingImages && $index === 0) {
                    $hasExistingImages = true;
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('message', 'Error uploading some images: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('message', "{$uploadedCount} image(s) uploaded successfully!");
    }
}