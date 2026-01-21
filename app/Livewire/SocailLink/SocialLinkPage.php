<?php

namespace App\Livewire\SocailLink;

use App\Models\SocialLink;
use Livewire\Component;
use Livewire\WithPagination;

class SocialLinkPage extends Component
{
    use WithPagination;
    public string $search = '';

    public bool $showDeleteModal = false;

    public ?SocialLink $socialLinkToDelete = null;

    protected $listeners = ['update-filter' => 'updateFilter'];

    public function openDeleteModal(int $socialLinkId): void
    {
        $this->socialLinkToDelete = SocialLink::findOrFail($socialLinkId);
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal(): void
    {
        $this->showDeleteModal = false;
        $this->socialLinkToDelete = null;
    }

    public function deleteSocialLink(): void
    {
        if ($this->socialLinkToDelete) {
            // Delete photo if exists
            if ($this->socialLinkToDelete->photo_url && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->socialLinkToDelete->photo_url)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($this->socialLinkToDelete->photo_url);
            }

            $this->socialLinkToDelete->delete();
            $this->closeDeleteModal();
            $this->dispatch('notify', [
                'variant' => 'success',
                'title' => 'Success',
                'message' => 'Social link deleted successfully.',
            ]);
        }
    }

    public function updateFilter($data)
    {
        $this->search = $data['search'];
    }


    public function render()
    {
        $socialLinks = SocialLink::when($this->search, function ($query) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('url', 'like', '%'.$this->search.'%');
            });
        })
            ->orderBy('name')
            ->paginate(12);

        return view('livewire.socail-link.social-link-page', [
            'socialLinks' => $socialLinks,
        ])->layout('components.layouts.app', [
            'header' => 'Social Links Management',
            'subtitle' => 'Manage your social media links and profiles',
        ]);
    }
}
