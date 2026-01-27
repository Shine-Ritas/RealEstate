<section class="bg-surface-variant py-16 md:py-20 lg:py-24">
    <div class="container mx-auto px-4 md:px-6 lg:px-8">
        <h2 class="mb-12 text-3xl font-bold text-on-surface md:text-4xl">
            {{ __('guest.primary_heading') }}
        </h2>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2 lg:gap-12">
            <div class="relative">
                <div class="overflow-hidden rounded-radius shadow-lg">
                    <img
                        src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800&h=600&fit=crop"
                        alt="Modern house"
                        class="h-80 w-full object-cover md:h-96 lg:h-[28rem]"
                    >
                </div>
                <div class="absolute -bottom-4 -right-4 flex gap-3 md:-right-6">
                    <div class="h-16 w-16 overflow-hidden rounded-full border-2 border-white shadow-md md:h-20 md:w-20">
                        <img
                            src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=160&h=160&fit=crop"
                            alt="Kitchen"
                            class="h-full w-full object-cover"
                        >
                    </div>
                    <div class="h-16 w-16 overflow-hidden rounded-full border-2 border-white shadow-md md:h-20 md:w-20">
                        <img
                            src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=160&h=160&fit=crop"
                            alt="Living room"
                            class="h-full w-full object-cover"
                        >
                    </div>
                    <div class="h-16 w-16 overflow-hidden rounded-full border-2 border-white shadow-md md:h-20 md:w-20">
                        <img
                            src="https://images.unsplash.com/photo-1616594039964-ae9021a400a0?w=160&h=160&fit=crop"
                            alt="Bedroom"
                            class="h-full w-full object-cover"
                        >
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-6">
                <div class="rounded-radius border border-outline bg-surface p-6 shadow-sm">
                    <h3 class="mb-3 text-xl font-semibold text-on-surface md:text-2xl">
                        {{ __('guest.primary_subheading') }}
                    </h3>
                    <p class="mb-6 text-on-surface-variant">
                        {{ __('guest.primary_description') }}
                    </p>
                    <a
                        href="#"
                        class="inline-flex rounded-radius bg-surface-variant px-5 py-2.5 text-sm font-semibold uppercase tracking-wide text-on-surface transition-colors hover:bg-outline"
                    >
                        {{ __('guest.btn_details') }}
                    </a>
                </div>
                <div class="rounded-radius border border-outline bg-surface p-6 shadow-sm">
                    <img
                        src="https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=400&h=260&fit=crop"
                        alt="Property"
                        class="mb-4 h-40 w-full rounded-radius object-cover"
                    >
                    <p class="mb-3 font-semibold text-success">
                        {{ __('guest.pricing_starts_at') }} $256K
                    </p>
                    <a
                        href="#"
                        class="inline-flex items-center gap-2 font-medium text-primary hover:text-primary-700"
                    >
                        {{ __('guest.btn_explore_properties') }}
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-16 grid grid-cols-2 gap-6 md:grid-cols-4 md:gap-8">
            <div class="text-center">
                <p class="text-2xl font-bold text-on-surface md:text-3xl">{{ __('guest.stat_satisfaction') }}</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-bold text-on-surface md:text-3xl">{{ __('guest.stat_property_sells') }}</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-bold text-on-surface md:text-3xl">{{ __('guest.stat_countries') }}</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-bold text-on-surface md:text-3xl">{{ __('guest.stat_reviews') }}</p>
            </div>
        </div>
    </div>
</section>
