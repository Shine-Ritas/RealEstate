<section class="bg-stone-100  pb-10">
    <div class="container mx-auto px-4 md:px-6 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <h2 class="mb-4 text-3xl font-bold text-on-surface md:text-4xl">
                {{ __('guest.value_heading') }}
            </h2>
            <p class="mb-8 text-on-surface-variant">
                {{ __('guest.value_description') }}
            </p>
            <a
                href="{{ route('home') }}#property-map-section"
                class="inline-flex items-center gap-2 rounded-radius bg-primary px-6 py-3 font-semibold text-on-primary transition-colors hover:bg-primary-700"
            >
                {{ __('guest.btn_find_newest') }}
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</section>
