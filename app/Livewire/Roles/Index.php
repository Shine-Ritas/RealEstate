<?php

namespace App\Livewire\Roles;

use App\Traits\BaseTrait;
use Livewire\Component;
use Spatie\Permission\Models\Role;

use Livewire\Attributes\Layout;

class Index extends Component
{
    use BaseTrait;

    protected mixed $roleToDelete = null;

    public bool $showDeleteModal = false;

    protected $listeners = ['role-saved' => '$refresh'];

    public function openDeleteModal(int $roleId): void
    {
        $this->roleToDelete = Role::findOrFail($roleId);
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal(): void
    {
        $this->showDeleteModal = false;
        $this->roleToDelete = null;
    }

    public function deleteRole(): void
    {
        Role::findOrFail($this->toDelete)->delete();

        $this->dispatch('notify', [
            'variant' => 'danger',
            'title' => 'Error',
            'message' => 'Role Deleted Successfully.',
        ]);
    }


    protected function layoutData(array $merge = [])
    {
        return [
            'header' => "Role Management",
            'subtitle' => 'Manage user roles and their permissions',
            ...$merge
        ];
    }

    public function render()
    {
        $roles = Role::withCount('permissions')
            ->orderBy('name')
            ->get();

        return view('livewire.roles.index', [
            'roles' => $roles,
        ])->layout('components.layouts.app', [
                    'header' => "Role Management",
                    'subtitle' => 'Manage user roles and their permissions',
                ]);
    }
}
