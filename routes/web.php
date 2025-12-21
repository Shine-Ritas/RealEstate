<?php

use App\Http\Controllers\PropertyImageController;
use App\Livewire\Facilities\Index as FacilitiesIndex;
use App\Livewire\Roles\Index as RolesIndex;
use App\Livewire\Roles\Permissions as RolesPermissionsIndex;

use App\Livewire\Property\Index as PropertyIndex;
use App\Livewire\Property\Form as PropertyForm;
use App\Livewire\Property\ImageForm as PropertyImageUpload;
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

    Route::get('properties',PropertyIndex::class)->name('properties.index');
    Route::get('/properties/create',PropertyForm::class)->name('properties.create');
    Route::get('/properties/{project}/edit',PropertyForm::class)->name('properties.edit');
    Route::get('/properties/{property}/image-upload',PropertyImageUpload::class)->name('properties.image-upload');
    Route::post('/properties/{property}/images/upload', [PropertyImageController::class, 'upload'])
    ->name('properties.images.upload');
});

Route::get('/', \App\Livewire\Guest\HomePage::class)->name('home');
Route::get('/detail', \App\Livewire\Guest\PropertyDetailPage::class)->name('detail');
