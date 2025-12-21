<?php

namespace App\Livewire\Property;

use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ImageForm extends Component
{
    use WithFileUploads;

    public Property $property;
    public $images = [];

    public function mount(Property $property): void
    {
        $this->property = $property->load('images');
    }

    public function upload(): void
    {
        $this->validate([
            'images' => 'required|array|min:1',
            'images.*' => 'required|image|max:10240', // 10MB max
        ]);

        $storagePath = "property/{$this->property->id}/images";
        $hasExistingImages = $this->property->images()->exists();
        $uploadedCount = 0;

        foreach ($this->images as $index => $image) {
            try {
                $filename = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs($storagePath, $filename, 'public');

                PropertyImage::create([
                    'property_id' => $this->property->id,
                    'image_path' => $path,
                    'is_primary' => !$hasExistingImages && $index === 0,
                ]);

                $uploadedCount++;

                if (!$hasExistingImages && $index === 0) {
                    $hasExistingImages = true;
                }
            } catch (\Exception $e) {
                session()->flash('message', 'Error uploading some images: ' . $e->getMessage());
                return;
            }
        }

        $this->images = [];
        $this->property->refresh();
        
        session()->flash('message', "{$uploadedCount} image(s) uploaded successfully!");
        
        // Dispatch browser event to reset Alpine state
        $this->dispatch('images-uploaded');
    }

    public function deleteImage(string $imageId): void
    {
        $image = PropertyImage::findOrFail($imageId);

        // Delete file from storage
        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        $wasPrimary = $image->is_primary;
        $image->delete();

        $this->property->refresh();

        // If deleted image was primary, set the first remaining image as primary
        if ($wasPrimary) {
            $firstImage = $this->property->images()->first();
            if ($firstImage) {
                $firstImage->update(['is_primary' => true]);
                $this->property->refresh();
            }
        }

        session()->flash('message', 'Image deleted successfully!');
    }

    public function setPrimary(string $imageId): void
    {
        // Remove primary from all images
        $this->property->images()->update(['is_primary' => false]);

        // Set new primary
        $image = PropertyImage::findOrFail($imageId);
        $image->update(['is_primary' => true]);

        $this->property->refresh();
        session()->flash('message', 'Primary image updated successfully!');
    }

    public function render()
    {
        return view('livewire.property.image-form', [
            'propertyImages' => $this->property->images()
                ->orderBy('is_primary', 'desc')
                ->orderBy('created_at', 'desc')
                ->get(),
        ])->layout('components.layouts.app', [
            'header' => $this->property->name . '\'s Images',
            'subtitle' => 'Upload and manage images for ' . $this->property->name,
        ]);
    }
}