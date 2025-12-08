<?php

use App\Livewire\Facilities\Form;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Form::class)
        ->assertStatus(200);
});
