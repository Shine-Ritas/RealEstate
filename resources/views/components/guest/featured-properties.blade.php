<section class="py-12 md:py-16 lg:py-20 bg-surface">
    <div class="container mx-auto px-4 md:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-10 md:mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-on-surface">{{ __('guest.featured_properties_title') }}</h2>
            <a href="#" class="text-primary hover:text-primary-800 font-semibold transition-colors">{{ __('guest.view_all') }}</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            <!-- Property 1: Luxury Condo in Sukhumvit -->
            <div class="bg-white dark:bg-surface-variant rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow border border-outline">
                <div class="relative">
                    <img 
                        src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=600&h=400&fit=crop" 
                        alt="Luxury Condo in Sukhumvit" 
                        class="w-full h-64 object-cover"
                    >
                    <span class="absolute bottom-4 left-4 px-3 py-1 bg-success text-on-success rounded-full text-sm font-semibold">
                        {{ __('guest.for_sale') }}
                    </span>
                    <div class="absolute bottom-4 right-4 text-primary text-2xl font-bold">
                        ฿15.5M
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-on-surface mb-2">Luxury Condo in Sukhumvit</h3>
                    <p class="text-on-surface-variant mb-4 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Bangkok, Thailand
                    </p>
                    <div class="flex items-center gap-6 mb-4 text-on-surface-variant text-sm">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            {{ $bedrooms ?? 3 }} {{ __('guest.beds') }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                            </svg>
                            {{ $bathrooms ?? 2 }} {{ __('guest.baths') }}
                        </span>
                        <span>120 sqm</span>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1 bg-primary-100 dark:bg-primary-900 text-primary rounded-full text-sm">Pool</span>
                        <span class="px-3 py-1 bg-primary-100 dark:bg-primary-900 text-primary rounded-full text-sm">Gym</span>
                    </div>
                </div>
            </div>

            <!-- Property 2: Modern House Chiang Mai -->
            <div class="bg-white dark:bg-surface-variant rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow border border-outline">
                <div class="relative">
                    <img 
                        src="https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=600&h=400&fit=crop" 
                        alt="Modern House Chiang Mai" 
                        class="w-full h-64 object-cover"
                    >
                    <span class="absolute bottom-4 left-4 px-3 py-1 bg-warning text-on-warning rounded-full text-sm font-semibold">
                        {{ __('guest.for_rent') }}
                    </span>
                    <div class="absolute bottom-4 right-4 text-primary text-2xl font-bold">
                        ฿45K/mo
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-on-surface mb-2">Modern House Chiang Mai</h3>
                    <p class="text-on-surface-variant mb-4 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Chiang Mai, Thailand
                    </p>
                    <div class="flex items-center gap-6 mb-4 text-on-surface-variant text-sm">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            4 Beds
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                            </svg>
                            3 Baths
                        </span>
                        <span>200 sqm</span>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1 bg-primary-100 dark:bg-primary-900 text-primary rounded-full text-sm">Garden</span>
                        <span class="px-3 py-1 bg-primary-100 dark:bg-primary-900 text-primary rounded-full text-sm">Parking</span>
                    </div>
                </div>
            </div>

            <!-- Property 3: Beachfront Villa Phuket -->
            <div class="bg-white dark:bg-surface-variant rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow border border-outline">
                <div class="relative">
                    <img 
                        src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=600&h=400&fit=crop" 
                        alt="Beachfront Villa Phuket" 
                        class="w-full h-64 object-cover"
                    >
                    <span class="absolute bottom-4 left-4 px-3 py-1 bg-success text-on-success rounded-full text-sm font-semibold">
                        {{ __('guest.for_sale') }}
                    </span>
                    <div class="absolute bottom-4 right-4 text-primary text-2xl font-bold">
                        ฿35M
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-on-surface mb-2">Beachfront Villa Phuket</h3>
                    <p class="text-on-surface-variant mb-4 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Phuket, Thailand
                    </p>
                    <div class="flex items-center gap-6 mb-4 text-on-surface-variant text-sm">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            5 Beds
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                            </svg>
                            4 Baths
                        </span>
                        <span>350 sqm</span>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1 bg-primary-100 dark:bg-primary-900 text-primary rounded-full text-sm">Beach</span>
                        <span class="px-3 py-1 bg-primary-100 dark:bg-primary-900 text-primary rounded-full text-sm">Pool</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

