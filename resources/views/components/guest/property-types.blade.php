<section class="py-12 md:py-16 lg:py-20 bg-surface-variant dark:bg-surface">
    <div class="container mx-auto px-4 md:px-6 lg:px-8">
        <h2 class="text-3xl md:text-4xl font-bold text-center text-on-surface mb-10 md:mb-12">
            {{ __('guest.property_types_title') }}
        </h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Condominiums -->
            <div class="bg-white dark:bg-surface-variant rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow border border-outline">
                <div class="w-12 h-12 bg-primary-100 dark:bg-primary-900 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-on-surface mb-2">{{ __('guest.property_type_condominiums') }}</h3>
                <p class="text-on-surface-variant">{{ __('guest.property_type_condominiums_desc') }}</p>
            </div>

            <!-- Houses -->
            <div class="bg-white dark:bg-surface-variant rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow border border-outline">
                <div class="w-12 h-12 bg-primary-100 dark:bg-primary-900 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-on-surface mb-2">{{ __('guest.property_type_houses') }}</h3>
                <p class="text-on-surface-variant">{{ __('guest.property_type_houses_desc') }}</p>
            </div>

            <!-- Land -->
            <div class="bg-white dark:bg-surface-variant rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow border border-outline">
                <div class="w-12 h-12 bg-primary-100 dark:bg-primary-900 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-on-surface mb-2">{{ __('guest.property_type_land') }}</h3>
                <p class="text-on-surface-variant">{{ __('guest.property_type_land_desc') }}</p>
            </div>

            <!-- Commercial -->
            <div class="bg-white dark:bg-surface-variant rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow border border-outline">
                <div class="w-12 h-12 bg-primary-100 dark:bg-primary-900 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-on-surface mb-2">{{ __('guest.property_type_commercial') }}</h3>
                <p class="text-on-surface-variant">{{ __('guest.property_type_commercial_desc') }}</p>
            </div>
        </div>
    </div>
</section>

