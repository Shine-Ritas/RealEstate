<div class="rounded-radius border border-outline bg-surface/80  shadow-lg md:p-8 flex gap-3">
    <div class="flex flex-col items-start gap-4 sm:flex-row sm:items-center sm:justify-between w-1/3 ">
        <div class="flex items-center gap-4">
            <img src="https://images.stockcake.com/public/1/b/2/1b233006-c7d5-4955-8499-b591153b7fd7_large/confident-business-professional-stockcake.jpg"
                alt="{{ __('guest.testimonial_author') }}" class="h-60 w-full rounded-lg object-cover">
        </div>
    </div>
    <div class="flex flex-col w-2/3 justify-between ">
        <blockquote class="mb-8 text-lg leading-relaxed text-on-surface md:text-xl">
            <span class=" inline-block text-3xl font-serif text-success" aria-hidden="true">"</span> {{ __('guest.testimonial_quote') }}
        </blockquote>
        <div>
            <p class="font-semibold text-on-surface">{{ __('guest.testimonial_author') }}</p>
            <p class="text-sm text-on-surface-variant">{{ __('guest.testimonial_role') }}</p>
        </div>
    </div>

</div>