@props([
    'property' => $property
])

<div class="swiper-slide">
    <div class="bg-surface border border-outline rounded-radius overflow-hidden shadow-sm hover:shadow-md transition-shadow group">
        {{-- Image Container with Overlays --}}
        <div class="relative h-52 overflow-hidden">
            @php
                $primaryImage = collect($property['images'])->firstWhere('is_primary', true)['image_url'] ?? ($property['images'][0]['image_url'] ?? null);
            @endphp
            @if($primaryImage)
                <img src="{{ $primaryImage }}" 
                     alt="{{ $property['name'] }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            @else
                <div class="w-full h-full bg-surface-variant flex items-center justify-center">
                    <img src="{{ asset('assets/no_image.jpg') }}" 
                         alt="{{ $property['name'] }}"
                         class="w-full h-full object-cover">
                </div>
            @endif

            {{-- Views Badge (Top Left) --}}
            <div class="absolute top-3 left-3 bg-primary text-on-primary px-3 py-1.5 rounded-full text-xs font-semibold shadow-md">
                {{ number_format($property['view_count'] ?? 0) }} Views
            </div>

            {{-- Status Ribbon (Top Right) --}}
            @php
                $statusColor = match($property['listing_type']) {
                    'sale' => 'bg-danger text-on-danger',
                    'rent' => 'bg-warning text-on-warning',
                    'both' => 'bg-success text-on-success',
                    default => 'bg-primary text-on-primary',
                };
                $statusText = match($property['listing_type']) {
                    'sale' => 'For Sale',
                    'rent' => 'For Rent',
                    'both' => 'For Sale/Rent',
                    default => 'Available',
                };  
            @endphp
            <div class="absolute top-0 right-0 {{ $statusColor }} px-4 py-2 text-xs font-bold shadow-lg" style="clip-path: polygon(0 0, 100% 0, 100% 100%, 0 85%);">
                {{ $statusText }}
            </div>
        </div>

        {{-- Card Content --}}
        <div class="px-4 py-2 space-y-1">
            {{-- Title --}}
            <h5 class="font-bold text-on-surface text-sm uppercase line-clamp-2 min-h-[1.5rem]">
                {{ $property['name'] }}
            </h5>

            {{-- Location --}}
            <div class="flex items-center gap-2 text-sm text-on-surface-variant">
                <i class="fa fa-solid fa-map-marker-alt text-primary"></i>
                <span class="line-clamp-1">
                    @if($property['subdistrict'] && $property['subdistrict']['s_name'])
                        {{ $property['subdistrict']['s_name'] }},
                    @endif
                    @if($property['province'] && $property['province']['p_name'])
                        {{ $property['province']['p_name'] }}
                    @endif
                </span>
            </div>

            {{-- Code and Posted Date --}}
            <div class="text-xs text-on-surface-variant">
                Code NRES-{{ strtoupper(substr($property['id'], -5)) }} - Posted in 
                {{ \Carbon\Carbon::parse($property['created_at'])->format('jS M, Y') }}
            </div>

            {{-- Price --}}
            <div class="text-lg font-bold text-primary">
                @php
                    $price = match($property['listing_type']) {
                        'sale' => $property['sale_price'] ?? null,
                        'rent' => $property['rent_price'] ?? null,
                        'both' => $property['current_price'] ?? null,
                        default => null,
                    };
                    $extra = match($property['listing_type']) {
                        'sale' => '> Sale',
                        'rent' => '/ Month',
                        'both' => 'Both',
                        default => '',
                    };
                @endphp
                @if($price)
                    {{ currency() }} {{ number_format($price, 0) }} {{ $extra }}
                @else
                    N/A
                @endif
            </div>

            {{-- Features --}}
            <div class="flex items-center gap-4 text-sm text-on-surface-variant pt-2 border-t border-divider">
                {{-- Land Area --}}
                @if($property['detail'] && isset($property['detail']['land_size_sqm']))
                    <span class="flex items-center gap-1">
                        <i class="fa fa-solid fa-ruler-combined"></i>
                        {{ number_format($property['detail']['land_size_sqm'], 2) }} sqm
                    </span>
                @endif

                {{-- Bedrooms --}}
                @if($property['detail'] && isset($property['detail']['bedrooms']))
                    <span class="flex items-center gap-1">
                        <i class="fa fa-solid fa-bed"></i>
                        {{ $property['detail']['bedrooms'] }} Bed
                    </span>
                @endif

                {{-- Car Parking --}}
                @php
                    $hasParking = collect($property['facilities'] ?? [])->contains(function($facility) {
                        return isset($facility['name']) && str_contains(strtolower($facility['name']), 'car parking');
                    });
                @endphp
                @if($hasParking)
                    <span class="flex items-center gap-1">
                        <i class="fa fa-solid fa-car"></i>
                        1 Car Parking
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>