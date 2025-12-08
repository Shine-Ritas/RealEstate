<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class Index extends Component
{
    public bool $showDeleteModal = false;

    public ?Role $roleToDelete = null;

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
        if ($this->roleToDelete) {
            $this->roleToDelete->delete();
            $this->closeDeleteModal();
            session()->flash('message', 'Role deleted successfully.');
        }
    }

    protected $listeners = ['role-saved' => '$refresh'];

    public function render()
    {
        $roles = Role::withCount('permissions')
            ->orderBy('name')
            ->get();

        return view('livewire.roles.index', [
            'roles' => $roles,
        ]);
    }
}
