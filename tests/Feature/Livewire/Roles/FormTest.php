<?php

use App\Livewire\Roles\Form;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Form::class)
        ->assertStatus(200);
});
