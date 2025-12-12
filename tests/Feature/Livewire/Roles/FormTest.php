<?php

declare(strict_types=1);

use App\Livewire\Roles\Form;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

// group
uses()->group('roles', 'form');

it('renders successfully', function () {
    Livewire::test(Form::class)
        ->assertStatus(200)
        ->assertSet('showModal', false)
        ->assertSet('roleId', null)
        ->assertSet('name', '')
        ->assertSet('description', '');
});

it('can open modal in create mode', function () {
    Livewire::test(Form::class)
        ->call('openModal')
        ->assertSet('showModal', true)
        ->assertSet('roleId', null)
        ->assertSet('name', '')
        ->assertSet('description', '')
        ->assertSee('Create Role');
});

it('can open modal in edit mode', function () {
    $role = Role::create([
        'name' => 'test-role',
        'description' => 'Test description',
    ]);

    Livewire::test(Form::class)
        ->call('openModal', $role->id)
        ->assertSet('showModal', true)
        ->assertSet('roleId', $role->id)
        ->assertSet('name', 'test-role')
        ->assertSet('description', 'Test description')
        ->assertSee('Edit Role');
});

it('can handle open modal event with role id', function () {
    $role = Role::create([
        'name' => 'test-role',
        'description' => 'Test description',
    ]);

    Livewire::test(Form::class)
        ->dispatch('open-role-form', ['roleId' => $role->id])
        ->assertSet('showModal', true)
        ->assertSet('roleId', $role->id)
        ->assertSet('name', 'test-role')
        ->assertSet('description', 'Test description');
});

it('can handle open modal event without role id', function () {
    Livewire::test(Form::class)
        ->dispatch('open-role-form')
        ->assertSet('showModal', true)
        ->assertSet('roleId', null)
        ->assertSet('name', '')
        ->assertSet('description', '');
});

it('can close modal', function () {
    Livewire::test(Form::class)
        ->call('openModal')
        ->assertSet('showModal', true)
        ->call('closeModal')
        ->assertSet('showModal', false)
        ->assertSet('roleId', null)
        ->assertSet('name', '')
        ->assertSet('description', '');
});

it('resets validation errors when opening modal', function () {
    Livewire::test(Form::class)
        ->set('name', '')
        ->call('save')
        ->assertHasErrors('name')
        ->call('openModal')
        ->assertHasNoErrors();
});

it('resets validation errors when closing modal', function () {
    Livewire::test(Form::class)
        ->set('name', '')
        ->call('save')
        ->assertHasErrors('name')
        ->call('closeModal')
        ->assertHasNoErrors();
});

it('validates name is required', function () {
    Livewire::test(Form::class)
        ->call('openModal')
        ->set('name', '')
        ->call('save')
        ->assertHasErrors(['name' => 'required']);
});

it('validates name is unique', function () {
    Role::create(['name' => 'existing-role']);

    Livewire::test(Form::class)
        ->call('openModal')
        ->set('name', 'existing-role')
        ->call('save')
        ->assertHasErrors(['name' => 'unique']);
});

it('allows duplicate name when editing same role', function () {
    $role = Role::create(['name' => 'test-role']);

    Livewire::test(Form::class)
        ->call('openModal', $role->id)
        ->set('name', 'test-role')
        ->set('description', 'Updated description')
        ->call('save')
        ->assertHasNoErrors();
});

it('validates name max length', function () {
    Livewire::test(Form::class)
        ->call('openModal')
        ->set('name', str_repeat('a', 256))
        ->call('save')
        ->assertHasErrors(['name' => 'max']);
});

it('validates description max length', function () {
    Livewire::test(Form::class)
        ->call('openModal')
        ->set('name', 'valid-role')
        ->set('description', str_repeat('a', 501))
        ->call('save')
        ->assertHasErrors(['description' => 'max']);
});

it('can create a role', function () {
    Livewire::test(Form::class)
        ->call('openModal')
        ->set('name', 'new-role')
        ->set('description', 'New role description')
        ->call('save')
        ->assertSet('showModal', false)
        ->assertDispatched('role-saved');

    expect(Role::where('name', 'new-role')->exists())->toBeTrue();

    $role = Role::where('name', 'new-role')->first();
    expect($role->description)->toBe('New role description');
});

it('can create a role without description', function () {
    Livewire::test(Form::class)
        ->call('openModal')
        ->set('name', 'role-without-description')
        ->set('description', '')
        ->call('save')
        ->assertSet('showModal', false)
        ->assertDispatched('role-saved');

    expect(Role::where('name', 'role-without-description')->exists())->toBeTrue();
});

it('can update a role', function () {
    $role = Role::create([
        'name' => 'original-role',
        'description' => 'Original description',
    ]);

    Livewire::test(Form::class)
        ->call('openModal', $role->id)
        ->set('name', 'updated-role')
        ->set('description', 'Updated description')
        ->call('save')
        ->assertSet('showModal', false)
        ->assertDispatched('role-saved');

    $role->refresh();
    expect($role->name)->toBe('updated-role')
        ->and($role->description)->toBe('Updated description');
});

it('can update a role without description', function () {
    $role = Role::create([
        'name' => 'role-with-description',
        'description' => 'Original description',
    ]);

    Livewire::test(Form::class)
        ->call('openModal', $role->id)
        ->set('name', 'role-with-description')
        ->set('description', '')
        ->call('save')
        ->assertSet('showModal', false)
        ->assertDispatched('role-saved');

    $role->refresh();
    expect($role->description)->toBeNull();
});

it('shows success message when creating a role', function () {
    $component = Livewire::test(Form::class)
        ->call('openModal')
        ->set('name', 'new-role')
        ->call('save')
        ->assertDispatched('role-saved');

    expect(session()->has('message'))->toBeTrue();
    expect(session('message'))->toBe('Role created successfully.');
});

it('shows success message when updating a role', function () {
    $role = Role::create(['name' => 'test-role']);

    $component = Livewire::test(Form::class)
        ->call('openModal', $role->id)
        ->set('name', 'updated-role')
        ->call('save')
        ->assertDispatched('role-saved');

    expect(session()->has('message'))->toBeTrue();
    expect(session('message'))->toBe('Role updated successfully.');
});

it('closes modal after successful save', function () {
    Livewire::test(Form::class)
        ->call('openModal')
        ->set('name', 'new-role')
        ->call('save')
        ->assertSet('showModal', false)
        ->assertSet('roleId', null)
        ->assertSet('name', '')
        ->assertSet('description', '');
});

it('does not create role when validation fails', function () {
    $initialCount = Role::count();

    Livewire::test(Form::class)
        ->call('openModal')
        ->set('name', '')
        ->call('save')
        ->assertHasErrors('name');

    expect(Role::count())->toBe($initialCount);
});

it('does not update role when validation fails', function () {
    $role = Role::create(['name' => 'original-role']);

    Livewire::test(Form::class)
        ->call('openModal', $role->id)
        ->set('name', '')
        ->call('save')
        ->assertHasErrors('name');

    $role->refresh();
    expect($role->name)->toBe('original-role');
});

it('handles non-existent role id when opening modal', function () {
    Livewire::test(Form::class)
        ->call('openModal', 99999)
        ->assertStatus(404);
});

it('handles non-existent role id when saving', function () {
    Livewire::test(Form::class)
        ->set('roleId', 99999)
        ->set('name', 'test-role')
        ->call('save')
        ->assertStatus(404);
});
