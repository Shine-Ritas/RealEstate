<?php

namespace App\Console\Commands;

use App\Models\District;
use App\Models\Facility;
use App\Models\LocationElement;
use App\Models\Property;
use App\Models\PropertyContact;
use App\Models\PropertyImage;
use App\Models\PropertyLocationElement;
use App\Models\Province;
use App\Models\Subdistrict;
use App\Services\Property\GeoLocationService;
use App\Services\Property\PropertyFacilityService;
use App\Services\Property\PropertyService;
use DB;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportScrapedProperty extends Command
{
    // 118

    protected $signature = 'import:property {--uuid=}';

    protected $description = 'Import scraped property data from Thaolai.com';

    public function handle(): int
    {
        $uuid = $this->option('uuid');

        // loop all json file under folder and get the data
         $datas = Storage::disk('public')->files(directory: 'property_api/');
        foreach ($datas as $data) {
            $data = json_decode(file_get_contents(storage_path('app/public/' . $data)), true);
            //     dd($data);
            $this->info("Importing property: {$data['name']}");

            if (!$data) {
                $this->error('Invalid JSON data provided');
                return Command::FAILURE;
            }

            if(Property::where('name', $data['name'])->exists()) {
                $this->info("Property already exists: {$data['name']}");
                continue;
            }

            try {
                DB::transaction(function () use ($data) {
                    // Find or create location codes
                    $locationCodes = $this->resolveLocationCodes($data['address'] ?? '');

                    // Create property
                    $property = Property::create([
                        'name' => $data['name'] ?? 'Unknown Property',
                        'description' => $data['description'] ?? '',
                        'property_type' => $this->mapPropertyType($data['propertyType'] ?? 'condo'),
                        'listing_type' => $this->mapListingType($data['listingType'] ?? 'rent'),
                        'rent_price' => $data['rentPrice'] ?? 0,
                        'sale_price' => $data['salePrice'] ?? 0,
                        'currency' => $data['currency'] ?? 'THB',
                        'latitude' => $data['latitude'] ?? null,
                        'longitude' => $data['longitude'] ?? null,
                        'address' => $data['address'] ?? '',
                        'p_code' => $locationCodes['p_code'],
                        'd_code' => $locationCodes['d_code'],
                        's_code' => $locationCodes['s_code'],
                        'zipcode' => $locationCodes['zipcode'],
                    ]);

                    // Create property details
                    if (!empty($data['details'])) {
                        (new PropertyService)->savePropertyDetail($property, [
                            'floor' => $data['details']['floor'] ?? 1,
                            'unit_number' => $data['details']['unitNumber'] ?? 1,
                            'bedrooms' => $data['details']['bedrooms'] ?? 1,
                            'bathrooms' => $data['details']['bathrooms'] ?? 1,
                            'size_sqm' => $data['details']['sizeSqm'] ?? 0,
                            'land_size_sqm' => $data['details']['landSizeSqm'] ?? 0,
                            'year_built' => $data['details']['yearBuilt'] ?? 200,
                            'number' => $data['details']['number'] ?? '',
                            'ownership' => $data['details']['ownership'] ?? 'freehold',
                            'status' => $data['details']['status'] ?? 'active',
                        ]);
                    }

                    // Download and save images
                    if (!empty($data['images'])) {
                        $this->saveImages($property, $data['images']);
                    }

                    // Save location elements
                    if (!empty($data['nearbyPlaces'])) {
                        $this->saveLocationElements($property, $data['nearbyPlaces']);
                    }

                    // Save contacts
                    if (!empty($data['contacts'])) {
                        $this->saveContacts($property, $data['contacts']);
                    }

                    // Save facilities
                    if (!empty($data['facilities'])) {
                        $facilityIds = $this->resolveFacilities($data['facilities']);
                        if (!empty($facilityIds)) {
                            (new PropertyFacilityService)->syncFacilities($property, $facilityIds);
                        }
                    }

                    $this->info("✅ Property imported successfully: {$property->name} (ID: {$property->id})");
                });

            } catch (\Exception $e) {
                $this->error("❌ Error importing property: " . $e->getMessage());
                $this->error($e->getTraceAsString());
             
            }
        }
        return Command::SUCCESS;

    }

    private function resolveLocationCodes(string $address): array
    {
        // Try to extract province, district from address
        // Format: "Mueang Nonthaburi, Nonaburi" or similar
        $parts = array_map('trim', explode(',', $address));

        // Try to find matching province and district
        $province = null;
        $district = null;
        $subdistrict = null;
        $zipcode = '';

        if (count($parts) >= 2) {
            $districtName = $parts[0];
            $provinceName = $parts[1] ?? '';

            // Search for province
            $province = Province::where('p_name', 'like', "%{$provinceName}%")
                ->first();

            if ($province) {
                // Search for district
                $district = District::where('p_code', $province->p_code)
                    ->where(function ($q) use ($districtName) {
                        $q->where('d_name', 'like', "%{$districtName}%");
                    })
                    ->first();

                if ($district) {
                    // Get first subdistrict as fallback
                    $subdistrict = Subdistrict::where('d_code', $district->d_code)->first();
                    if ($subdistrict) {
                        $zipcode = $subdistrict->zip_code;
                    }
                }
            }
        }

        // Fallback to Bangkok if not found
        if (!$province) {
            $province = Province::where('p_name', 'like', '%Bangkok%')->first();
        }
        if (!$district && $province) {
            $district = District::where('p_code', $province->p_code)->first();
        }
        if (!$subdistrict && $district) {
            $subdistrict = Subdistrict::where('d_code', $district->d_code)->first();
            if ($subdistrict) {
                $zipcode = $subdistrict->zip_code;
            }
        }

        return [
            'p_code' => $province->p_code ?? '100000',
            'd_code' => $district->d_code ?? '100101',
            's_code' => $subdistrict->s_code ?? '10010101',
            'zipcode' => $zipcode ?: '10100',
        ];
    }

    private function mapPropertyType(string $type): string
    {
        $mapping = [
            'condo' => 'condo',
            'apartment' => 'apartment',
            'house' => 'house',
            'villa' => 'villa',
            'townhouse' => 'townhouse',
            'land' => 'land',
            'commercial' => 'commercial',
        ];

        return $mapping[strtolower($type)] ?? 'condo';
    }

    private function mapListingType(string $type): string
    {
        return match (strtolower($type)) {
            'rent', 'rental' => 'rent',
            'sale', 'sell' => 'sale',
            'both' => 'both',
            default => 'rent',
        };
    }

    private function saveImages(Property $property, array $images): void
    {
        $storagePath = "property/{$property->id}/images";
        $isFirst = true;

        foreach ($images as $imageUrl) {
            try {
                // Download image using file_get_contents
                $imageData = @file_get_contents($imageUrl);
                if ($imageData === false) {
                    continue;
                }

                $extension = pathinfo(parse_url($imageUrl, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
                $filename = uniqid() . '_' . time() . '.' . $extension;
                $path = $storagePath . '/' . $filename;

                // Save to storage
                Storage::disk('public')->put($path, $imageData);

                PropertyImage::create([
                    'property_id' => $property->id,
                    'image_path' => $path,
                    'image_url' => $imageUrl,
                    'is_primary' => $isFirst,
                ]);

                $isFirst = false;
            } catch (\Exception $e) {
                $this->warn("Failed to download image: {$imageUrl} - " . $e->getMessage());
            }
        }
    }

    private function saveLocationElements(Property $property, array $nearbyPlaces): void
    {
        $iconMapping = [
            'hospital' => 'hospital',
            'train' => 'train station',
            'airport' => 'airport',
            'school' => 'school',
            'restaurant' => 'restaurant',
            'shopping' => 'shopping mall',
        ];

        foreach ($nearbyPlaces as $place) {
            $iconName = $place['icon'] ?? '';
            $locationType = $iconMapping[$iconName] ?? 'other';

            $locationElement = LocationElement::where('name', $locationType)->first();

            if (!$locationElement) {
                // Create if doesn't exist
                $locationElement = LocationElement::create([
                    'name' => $locationType,
                    'icon' => $iconName ?: 'map-marker',
                    'status' => 'active',
                ]);
            }

            PropertyLocationElement::create([
                'property_id' => $property->id,
                'location_element_id' => $locationElement->id,
                'name' => $place['name'] ?? '',
                'details' => $place['name'] ?? '',
                'distance' => $place['distance'] ?? '',
            ]);
        }
    }

    private function saveContacts(Property $property, array $contacts): void
    {
        $contactTypeMapping = [
            'tel' => 'phone',
            'line' => 'line',
            'email' => 'email',
            'website' => 'website',
        ];

        foreach ($contacts as $contact) {
            $type = $contact['type'] ?? 'agent'; // 'office' or 'agent'
            $contactType = $contactTypeMapping[$contact['contactType'] ?? 'phone'] ?? 'phone';
            $text = $contact['text'] ?? '';
            $url = $contact['url'] ?? '';

            PropertyContact::create([
                'property_id' => $property->id,
                'type' => $type,
                'text' => $text,
                'icon' => $contact['icon'] ?? 'phone',
                'contact_type' => $contactType,
                'url' => $url,
            ]);
        }
    }

    private function resolveFacilities(array $facilityNames): array
    {
        $facilityIds = [];

        foreach ($facilityNames as $name) {
            $facility = Facility::where('name', 'like', "%{$name}%")
                ->orWhere('name', $name)
                ->first();

            if ($facility) {
                $facilityIds[] = $facility->id;
            } else {
                // Try to create if doesn't exist
                $facility = Facility::create([
                    'name' => $name,
                    'icon' => 'star',
                    'status' => 'active',
                ]);
                $facilityIds[] = $facility->id;
            }
        }

        return $facilityIds;
    }
}
