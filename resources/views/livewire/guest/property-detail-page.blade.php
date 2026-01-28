<div>
    @php
        $locationParts = array_filter([
            $property->subdistrict?->s_name,
            $property->district?->d_name,
            $property->province?->p_name,
        ]);
        $breadcrumbLocation = implode(', ', $locationParts);

        $listingPrice = match ($property->listing_type) {
            'sale' => $property->sale_price,
            'rent' => $property->rent_price,
            'both' => $property->current_price,
            default => $property->current_price,
        };

        $sizeSqm = $property->detail?->size_sqm;
        $pricePerSqm = ($listingPrice && $sizeSqm)
            ? currency() . ' ' . number_format($listingPrice / $sizeSqm, 0) . ' per sqm'
            : null;

        $agentPhone = $property->contacts
            ->firstWhere('contact_type', 'phone')
            ?->text;

        $agentEmail = $property->contacts
            ->firstWhere('contact_type', 'email')
            ?->text;
    @endphp

    <x-guest.breadcrumb :location="$breadcrumbLocation" :current="$property->name" />

    <div class="container mx-auto px-4 md:px-6 lg:px-8 py-8 md:py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Property Gallery -->
                <x-guest.property-gallery :property="$property" />

                <!-- Property Description -->
                <x-guest.property-description :description="$property->description" />

                <!-- Special Features -->
                <x-guest.special-features />

                <!-- Nearby Locations -->
                <x-guest.nearby-locations />
            </div>

            <!-- Right Column -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Property Summary -->
                <x-guest.property-summary 
                    :title="$property->name"
                    :location="$property->address . ($breadcrumbLocation ? ', ' . $breadcrumbLocation : '')"
                    :price="$property->normal_show_price"
                    :pricePerSqm="$pricePerSqm"
                    :bedrooms="$property->detail?->bedrooms ?? '-'"
                    :bathrooms="$property->detail?->bathrooms ?? '-'"
                    :size="($property->detail?->size_sqm ? number_format($property->detail->size_sqm, 2) . ' Sqm' : '-')"
                    :propertyCode="$property->property_code"
                    :floor="($property->detail?->floor ? $property->detail->floor . ' Floor' : '-')"
                />

                <!-- Contact Information -->
                <x-guest.contact-information 
                    :ownerName="$property->owner_name ?? __('guest.property_owner')"
                    :ownerRole="__('guest.property_owner')"
                    :ownerImage="'https://ui-avatars.com/api/?name=' . urlencode($property->owner_name ?? 'Owner') . '&background=1e40af&color=fff'"
                    :phone="$agentPhone ?? '+66 00 000 0000'"
                    :email="$agentEmail ?? 'info@example.com'"
                />

                <!-- Property Details -->
                <x-guest.property-details :property="$property" />

                <!-- Schedule Viewing -->
                <x-guest.schedule-viewing />
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            Fancybox.bind("[data-fancybox]", {});
        </script>
    @endpush
</div>
