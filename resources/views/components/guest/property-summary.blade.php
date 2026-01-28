<div class="bg-white dark:bg-surface-variant rounded-xl p-6 md:p-8 border border-outline ">
    <h1 class="text-3xl font-bold text-on-surface mb-2">{{ $title ?? 'Luxury Sky Residence' }}</h1>
    
    <div class="flex items-center gap-2 text-on-surface-variant mb-6">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <span>{{ $location ?? 'Sukhumvit 21, Asoke, Bangkok' }}</span>
    </div>

    <div class="mb-6 pb-6 border-b border-outline">
        <div class="text-3xl font-bold text-primary mb-1">{{ $price ?? '฿12.5M' }}</div>
        <div class="text-sm text-on-surface-variant">{{ $pricePerSqm ?? '฿125,000 per sqm' }}</div>
    </div>

    <div class="grid grid-cols-3 gap-4 mb-6 pb-6 border-b border-outline">
        <div class="text-center">
            <div class="flex items-center justify-center w-10 h-10 bg-primary-100 dark:bg-primary-900 rounded-lg mx-auto mb-2">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
            </div>
            <p class="text-sm text-on-surface-variant">{{ __('guest.beds') }}</p>
            <p class="font-semibold text-on-surface">{{ $bedrooms ?? '2' }}</p>
        </div>
        <div class="text-center">
            <div class="flex items-center justify-center w-10 h-10 bg-primary-100 dark:bg-primary-900 rounded-lg mx-auto mb-2">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                </svg>
            </div>
            <p class="text-sm text-on-surface-variant">{{ __('guest.baths') }}</p>
            <p class="font-semibold text-on-surface">{{ $bathrooms ?? '2' }}</p>
        </div>
        <div class="text-center">
            <div class="flex items-center justify-center w-10 h-10 bg-primary-100 dark:bg-primary-900 rounded-lg mx-auto mb-2">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                </svg>
            </div>
            <p class="text-sm text-on-surface-variant">Size</p>
            <p class="font-semibold text-on-surface">{{ $size ?? '100 Sqm' }}</p>
        </div>
    </div>

    <div class="space-y-3 mb-6">
        <div class="flex justify-between">
            <span class="text-on-surface-variant">{{ __('guest.property_code') }}:</span>
            <span class="font-semibold text-on-surface">{{ $propertyCode ?? '#TH2024001' }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-on-surface-variant">{{ __('guest.floor') }}:</span>
            <span class="font-semibold text-on-surface">{{ $floor ?? '25th Floor' }}</span>
        </div>
    </div>
</div>

