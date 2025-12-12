<?php

use App\Livewire\Project\Index as ProjectIndex;
use App\Livewire\Facilities\Index as FacilitiesIndex;
use App\Livewire\Roles\Index as RolesIndex;
use App\Livewire\Roles\Permissions as RolesPermissionsIndex;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');

    // Role Management Routes
    Route::get('/roles', RolesIndex::class)->name('roles.index');

    Route::get('/roles/{roleId}/permissions', RolesPermissionsIndex::class)->name('roles.permissions');

    // Facility Management Routes
    Route::get('/facilities', FacilitiesIndex::class)->name('facilities.index');

    Route::get('projects',ProjectIndex::class);
});

Route::get('/', \App\Livewire\Guest\HomePage::class)->name('home');
Route::get('/detail', \App\Livewire\Guest\PropertyDetailPage::class)->name('detail');
