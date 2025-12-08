<?php

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
    Route::get('/roles', function () {
        return view('roles.index');
    })->name('roles.index');

    Route::get('/roles/{roleId}/permissions', function ($roleId) {
        return view('roles.permissions', ['roleId' => (int) $roleId]);
    })->name('roles.permissions');

    // Facility Management Routes
    Route::get('/facilities', function () {
        return view('facilities.index');
    })->name('facilities.index');
});

Route::get('/', \App\Livewire\Guest\HomePage::class)->name('home');
Route::get('/detail', \App\Livewire\Guest\PropertyDetailPage::class)->name('detail');
