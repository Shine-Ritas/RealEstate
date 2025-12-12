<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class Form extends Component
{
    public bool $showModal = false;

    public ?int $roleId = null;

    public string $name = '';

    public string $description = '';

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:roles,name,'.$this->roleId],
            'description' => ['nullable', 'string', 'max:500'],
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'The role name is required.',
            'name.unique' => 'A role with this name already exists.',
        ];
    }

    protected $listeners = ['open-role-form' => 'handleOpenModal'];

    public function handleOpenModal($data = []): void
    {
        $roleId = $data['roleId'] ?? null;
        $this->openModal($roleId);
    }

    public function openModal(?int $roleId = null): void
    {
        $this->roleId = $roleId;

        if ($roleId) {
            $role = Role::find($roleId);

            if (! $role) {
                abort(404);
            }

            $this->name = $role->name;
            $this->description = $role->description ?? '';
        } else {
            $this->reset(['name', 'description']);
        }

        $this->resetValidation();
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset(['roleId', 'name', 'description']);
        $this->resetValidation();
    }

    public function save(): void
    {
        $this->validate();

        $description = $this->description === '' ? null : $this->description;

        if ($this->roleId) {
            $role = Role::find($this->roleId);

            if (! $role) {
                abort(404);
            }

            $role->update([
                'name' => $this->name,
                'description' => $description,
            ]);
            session()->put('message', 'Role updated successfully.');
        } else {
            Role::create([
                'name' => $this->name,
                'description' => $description,
            ]);
            session()->put('message', 'Role created successfully.');
        }

        $this->closeModal();
        $this->dispatch('role-saved');
    }

    public function render()
    {
        return view('livewire.roles.form');
    }
}
