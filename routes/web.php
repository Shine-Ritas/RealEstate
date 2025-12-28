<?php

use App\Http\Controllers\PropertyImageController;
use App\Livewire\Facilities\Index as FacilitiesIndex;
use App\Livewire\Property\Form as PropertyForm;
use App\Livewire\Property\GeoForm;
use App\Livewire\Property\ImageForm as PropertyImageUpload;
use App\Livewire\Property\Index as PropertyIndex;
use App\Livewire\Roles\Index as RolesIndex;
use App\Livewire\Roles\Permissions as RolesPermissionsIndex;
use App\Livewire\SocailLink\SocailLinkForm;
use App\Livewire\SocailLink\SocialLinkPage;
use App\Livewire\Users\Index as UsersIndex;
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

    // User Management Routes
    Route::get('/users', UsersIndex::class)->name('users.index');

    // Facility Management Routes
    Route::get('/facilities', FacilitiesIndex::class)->name('facilities.index');

    Route::get('properties', PropertyIndex::class)->name('properties.index');
    Route::get('/properties/create', PropertyForm::class)->name('properties.create');
    Route::get('/properties/{property}/edit', action: PropertyForm::class)->name('properties.edit');
    Route::get('/properties/{property}/image-upload', PropertyImageUpload::class)->name('properties.image-upload');
    Route::get('/properties/{property}/geo-location', GeoForm::class)->name('properties.geo-location');
    Route::post('/properties/{property}/images/upload', [PropertyImageController::class, 'upload'])
        ->name('properties.images.upload');

    Route::get('social-links', SocialLinkPage::class)->name('social-links.index');
    Route::get('social-links/create', SocailLinkForm::class)->name('social-links.create');
    Route::get('social-links/{socialLink}/edit', SocailLinkForm::class)->name('social-links.edit');
});

Route::get('/', \App\Livewire\Guest\HomePage::class)->name('home');
Route::get('/detail', \App\Livewire\Guest\PropertyDetailPage::class)->name('detail');
