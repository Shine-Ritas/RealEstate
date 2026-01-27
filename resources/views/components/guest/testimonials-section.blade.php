<section class="bg-surface py-16 md:py-20 lg:py-24">
    <div class="container mx-auto px-4 md:px-6 lg:px-8">
        <h2 class="mb-12 text-3xl font-bold text-on-surface md:text-4xl">
            {{ __('guest.testimonials_title') }}
        </h2>

        <div class="grid gap-3 grid-cols-1 md:grid-cols-2">
            <x-guest.client-card />
            <x-guest.client-card />
        </div>
    </div>
</section>
