<?php

namespace App\Livewire\Users;

use App\Models\User;
use App\Traits\BaseTrait;
use Livewire\Component;

class Index extends Component
{
    use BaseTrait;

    protected mixed $userToDelete = null;

    public bool $showDeleteModal = false;

    protected $listeners = ['user-saved' => '$refresh'];

    public function openDeleteModal(int $userId): void
    {
        $this->userToDelete = User::findOrFail($userId);
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal(): void
    {
        $this->showDeleteModal = false;
        $this->userToDelete = null;
    }

    public function deleteUser(): void
    {
        User::findOrFail($this->toDelete)->delete();

        $this->dispatch('notify', [
            'variant' => 'danger',
            'title' => 'Success',
            'message' => 'User Deleted Successfully.',
        ]);

        $this->closeDeleteModal();
    }

    protected function layoutData(array $merge = []): array
    {
        return [
            'header' => 'User Management',
            'subtitle' => 'Manage users and their roles',
            ...$merge,
        ];
    }

    public function render()
    {
        $users = User::with('roles')
            ->orderBy('name')
            ->get();

        return view('livewire.users.index', [
            'users' => $users,
        ])->layout('components.layouts.app', [
            'header' => 'User Management',
            'subtitle' => 'Manage users and their roles',
        ]);
    }
}









