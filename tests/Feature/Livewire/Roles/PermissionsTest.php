<?php

declare(strict_types=1);

use App\Livewire\Roles\Permissions;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

it('renders successfully', function () {
    $role = Role::create([
        'name' => 'test-role',
    ]);

    Livewire::test(Permissions::class, ['roleId' => $role->id])
        ->assertStatus(200)
        ->assertSet('role.id', $role->id);
});
