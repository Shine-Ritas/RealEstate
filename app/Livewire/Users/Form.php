<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Form extends Component
{
    public bool $showModal = false;

    public ?int $userId = null;

    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public ?int $roleId = null;

    protected function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$this->userId],
            'roleId' => ['nullable', 'integer', 'exists:roles,id'],
        ];

        if ($this->userId) {
            $rules['password'] = ['nullable', 'string', 'min:8', 'confirmed'];
        } else {
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }

        return $rules;
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'The name is required.',
            'email.required' => 'The email is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'A user with this email already exists.',
            'password.required' => 'The password is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
            'roleId.exists' => 'The selected role does not exist.',
        ];
    }

    protected $listeners = ['open-user-form' => 'handleOpenModal'];

    public function handleOpenModal($data = []): void
    {
        $userId = $data['userId'] ?? null;
        $this->openModal($userId);
    }

    public function openModal(?int $userId = null): void
    {
        $this->userId = $userId;

        if ($userId) {
            $user = User::with('roles')->find($userId);

            if (! $user) {
                abort(404);
            }

            $this->name = $user->name;
            $this->email = $user->email;
            $this->roleId = $user->roles->first()?->id;
        } else {
            $this->reset(['name', 'email', 'password', 'password_confirmation', 'roleId']);
        }

        $this->resetValidation();
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset(['userId', 'name', 'email', 'password', 'password_confirmation', 'roleId']);
        $this->resetValidation();
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        if (! empty($this->password)) {
            $data['password'] = $this->password;
        }

        if ($this->userId) {
            $user = User::find($this->userId);

            if (! $user) {
                abort(404);
            }

            $user->update($data);

            if ($this->roleId) {
                $role = Role::find($this->roleId);
                $user->syncRoles([$role]);
            } else {
                $user->syncRoles([]);
            }

            session()->put('message', 'User updated successfully.');
        } else {
            $user = User::create($data);

            if ($this->roleId) {
                $role = Role::find($this->roleId);
                $user->assignRole($role);
            }

            session()->put('message', 'User created successfully.');
        }

        $this->closeModal();
        $this->dispatch('user-saved');
    }

    public function render()
    {
        $roles = Role::orderBy('name')->get()->map(function ($role) {
            return [
                'value' => $role->id,
                'label' => ucfirst($role->name),
            ];
        })->toArray();

        return view('livewire.users.form', [
            'roles' => $roles,
        ]);
    }
}
