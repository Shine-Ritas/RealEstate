<?php

namespace App\Livewire\SocailLink;

use App\Models\SocialLink;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class SocailLinkForm extends Component
{
    use WithFileUploads;

    public ?string $socialLinkId = null;

    public string $name = '';

    public string $url = '';

    public ?string $icon = '';

    public $photo = null;

    public ?string $photoUrl = null;

    public string $status = 'active';

    public string $displayType = 'icon'; // 'icon' or 'photo'

    protected function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'url' => ['required', 'max:500'],
            'status' => ['required', 'in:active,inactive'],
            'displayType' => ['required', 'in:icon,photo'],
        ];

        if ($this->displayType === 'icon') {
            $rules['icon'] = ['required', 'string', 'max:255'];
        } else {
            if (! $this->socialLinkId || $this->photo) {
                $rules['photo'] = ['required', 'image', 'max:2048']; // 2MB max
            }
        }

        return $rules;
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'The social link name is required.',
            'url.required' => 'The URL is required.',
            'url.url' => 'Please enter a valid URL.',
            'icon.required' => 'The icon name is required when using icon display.',
            'photo.required' => 'Please upload a photo when using photo display.',
            'photo.image' => 'The uploaded file must be an image.',
            'photo.max' => 'The photo size must not exceed 2MB.',
            'status.required' => 'The status is required.',
        ];
    }

    public function mount(?SocialLink $socialLink = null): void
    {
        if ($socialLink) {
            $this->socialLinkId = $socialLink->id;
            $this->name = $socialLink->name;
            $this->url = $socialLink->url;
            $this->status = $socialLink->status ?? 'active';
            $this->icon = $socialLink->icon ?? '';
            $this->photoUrl = $socialLink->photo_url;

            // Determine display type based on existing data
            $this->displayType = $socialLink->photo_url ? 'photo' : 'icon';
        } else {
            $this->reset(['name', 'url', 'icon', 'photo', 'photoUrl', 'status', 'displayType']);
            $this->status = 'active';
            $this->displayType = 'icon';
        }
    }

    public function updatedDisplayType(): void
    {
        // Clear validation errors when switching display type
        $this->resetValidation(['icon', 'photo']);
    }

    public function save(): void
    {
    
        $this->validate();


        $data = [
            'name' => $this->name,
            'url' => $this->url,
            'status' => $this->status,
        ];

        if ($this->displayType === 'icon') {
            $data['icon'] = $this->icon;
            $data['photo_url'] = null;

            // Delete old photo if switching from photo to icon
            if ($this->socialLinkId && $this->photoUrl) {
                $this->deleteOldPhoto();
            }
        } else {
            $data['icon'] = null;

            // Handle photo upload
            if ($this->photo) {
                // Delete old photo if exists
                if ($this->socialLinkId && $this->photoUrl) {
                    $this->deleteOldPhoto();
                }

                // Store new photo
                $path = $this->photo->store('social-links', 'public');
                $data['photo_url'] = $path;
            } else {
                // Keep existing photo if editing and no new photo uploaded
                $data['photo_url'] = $this->photoUrl;
            }
        }

        if ($this->socialLinkId) {
            $socialLink = SocialLink::findOrFail($this->socialLinkId);
            $socialLink->update($data);
            session()->flash('message', 'Social link updated successfully.');
        } else {
            SocialLink::create($data);
            session()->flash('message', 'Social link created successfully.');
        }

        $this->redirect(route('social-links.index'), navigate: true);
    }

    private function deleteOldPhoto(): void
    {
        if ($this->photoUrl && Storage::disk('public')->exists($this->photoUrl)) {
            Storage::disk('public')->delete($this->photoUrl);
        }
    }

    public function render()
    {
        return view('livewire.socail-link.socail-link-form')->layout('components.layouts.app', [
            'header' => $this->socialLinkId ? 'Edit Social Link' : 'Create Social Link',
            'subtitle' => $this->socialLinkId ? 'Update social link information' : 'Add a new social link to the system',
        ]);
    }
}
