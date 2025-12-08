<?php

use App\Livewire\Roles\Permissions;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Permissions::class)
        ->assertStatus(200);
});
