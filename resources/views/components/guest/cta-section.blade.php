<section class="relative overflow-hidden bg-primary py-16 md:py-20 lg:py-24">
    <div class="hero-overlay absolute inset-0" aria-hidden="true"></div>
    <div class="cta-bg absolute inset-0 opacity-30" aria-hidden="true"></div>

    <div class="container relative z-10 mx-auto px-4 text-center md:px-6 lg:px-8">
        <h2 class="mb-4 text-3xl font-bold text-white md:text-4xl lg:text-5xl">
            {{ __('guest.cta_title') }}
        </h2>
        <p class="mx-auto mb-8 max-w-2xl text-lg text-gray-300 md:text-xl">
            {{ __('guest.cta_subtitle') }}
        </p>
        <a
            href="{{ route('register') }}"
            class="inline-flex items-center gap-2 rounded-radius bg-white px-6 py-3 font-semibold text-primary transition-colors hover:bg-gray-100"
        >
            {{ __('guest.btn_get_started') }}
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
        </a>
    </div>
</section>
