<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Permissions extends Component
{
    public Role $role;

    public array $selectedPermissions = [];

    public function mount(int $roleId): void
    {
        $this->role = Role::findOrFail($roleId);
        $this->selectedPermissions = $this->role->permissions->pluck('id')->toArray();
    }

    public function togglePermission(int $permissionId): void
    {
        if (in_array($permissionId, $this->selectedPermissions)) {
            $this->selectedPermissions = array_diff($this->selectedPermissions, [$permissionId]);
        } else {
            $this->selectedPermissions[] = $permissionId;
        }
    }

    public function savePermissions(): void
    {
        $permissions = Permission::whereIn('id', $this->selectedPermissions)->get();
        $this->role->syncPermissions($permissions);

        session()->flash('message', 'Permissions updated successfully.');
        $this->dispatch('permissions-saved');
    }

    public function render()
    {
        $permissions = Permission::orderBy('name')
            ->get()
            ->groupBy(function ($permission) {
                // Group by module (e.g., 'view-users' -> 'users')
                $parts = explode('-', $permission->name);

                return count($parts) > 1 ? $parts[1] : 'other';
            });

        return view('livewire.roles.permissions', [
            'permissions' => $permissions,
        ]);
    }
}
