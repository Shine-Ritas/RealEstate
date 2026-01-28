<?php

use App\Models\District;
use App\Models\Property;
use App\Models\PropertyContact;
use App\Models\PropertyDetail;
use App\Models\PropertyImage;
use App\Models\Province;
use App\Models\Subdistrict;

it('renders guest property detail page with real data and fancybox gallery', function () {
    $province = Province::create([
        'p_code' => '100000',
        'p_name' => 'Bangkok',
    ]);

    $district = District::create([
        'd_code' => '100000000001',
        'd_name' => 'Watthana',
        'p_code' => $province->p_code,
    ]);

    $subdistrict = Subdistrict::create([
        's_code' => '10000000000101',
        's_name' => 'Khlong Toei',
        'd_code' => $district->d_code,
        'zip_code' => '10110',
    ]);

    $property = Property::create([
        'name' => 'Luxury Sky Residence',
        'description' => 'A beautiful condo in Bangkok.',
        'property_type' => 'condo',
        'listing_type' => 'sale',
        'sale_price' => 12500000,
        'currency' => 'THB',
        'owner_name' => 'Somchai Rattanakul',
        'address' => 'Sukhumvit 21, Asoke',
        'zipcode' => '10110',
        'p_code' => $province->p_code,
        'd_code' => $district->d_code,
        's_code' => $subdistrict->s_code,
    ]);

    PropertyDetail::create([
        'property_id' => $property->id,
        'bedrooms' => 2,
        'bathrooms' => 2,
        'floor' => 25,
        'unit_number' => 2501,
        'number' => 'A',
        'size_sqm' => 100,
        'land_size_sqm' => null,
        'year_built' => 2023,
        'ownership' => 'freehold',
        'status' => 'active',
    ]);

    PropertyImage::create([
        'property_id' => $property->id,
        'image_path' => 'properties/test-1.jpg',
        'is_primary' => true,
    ]);

    PropertyImage::create([
        'property_id' => $property->id,
        'image_path' => 'properties/test-2.jpg',
        'is_primary' => false,
    ]);

    PropertyContact::create([
        'property_id' => $property->id,
        'type' => 'agent',
        'text' => '+66 89 123 4567',
        'icon' => 'phone',
        'contact_type' => 'phone',
        'url' => null,
    ]);

    PropertyContact::create([
        'property_id' => $property->id,
        'type' => 'agent',
        'text' => 'agent@example.com',
        'icon' => 'email',
        'contact_type' => 'email',
        'url' => null,
    ]);

    $this->get(route('detail', $property))
        ->assertSuccessful()
        ->assertSee($property->name)
        ->assertSee($property->description)
        ->assertSee('data-fancybox="property-'.$property->id.'"', false);
});
