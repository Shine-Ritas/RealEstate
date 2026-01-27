<section class="relative z-20 -mt-32 md:-mt-28 lg:-mt-32">
    <div class="container mx-auto px-4 md:px-6 lg:px-8">
        <div class="rounded-2xl bg-surface py-3 px-5 shadow-xl md:p-8 text-xs md:text-sm">
            <h2 class="mb-2 md:mb-6 text-lg font-semibold text-on-surface md:text-2xl">
                {{ __('guest.search_find_best_place') }}
            </h2>

            <form id="guest-search-form" action="{{ route('home') }}" method="get" class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
                <div>
                    <label class="mb-2 block  font-medium text-on-surface-variant">
                        {{ __('guest.search_looking_for') }} ({{ __('guest.search_looking_placeholder') }})
                    </label>
                    <input
                        type="text"
                        name="type"
                        class="w-full rounded-radius border border-outline bg-surface-variant px-4 py-3 text-on-surface placeholder-on-surface-variant focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                        placeholder="{{ __('guest.search_looking_placeholder') }}"
                    >
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-on-surface-variant">
                        {{ __('guest.search_price_range') }}
                    </label>
                    <select
                        name="price"
                        class="w-full rounded-radius border border-outline bg-surface-variant px-4 py-3 text-on-surface focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                    >
                        <option value="">{{ __('guest.option_any_price') }}</option>
                        <option>Under ฿5M</option>
                        <option>฿5M - ฿15M</option>
                        <option>฿15M - ฿30M</option>
                        <option>Over ฿30M</option>
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-on-surface-variant">
                        {{ __('guest.search_location') }}
                    </label>
                    <input
                        type="text"
                        name="location"
                        placeholder="{{ __('guest.search_location_placeholder') }}"
                        class="w-full rounded-radius border border-outline bg-surface-variant px-4 py-3 text-on-surface placeholder-on-surface-variant focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                    >
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-on-surface-variant">
                        {{ __('guest.search_bedrooms') }} ({{ __('guest.search_bedrooms_example') }})
                    </label>
                    <select
                        name="bedrooms"
                        class="w-full rounded-radius border border-outline bg-surface-variant px-4 py-3 text-on-surface focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                    >
                        <option value="">{{ __('guest.option_any') }}</option>
                        <option>1+</option>
                        <option>2+</option>
                        <option>3+</option>
                        <option>4+</option>
                        <option>5+</option>
                    </select>
                </div>
            </form>

            <div class="mt-6 flex flex-wrap items-center gap-3">
              
                <button
                    type="button"
                    class="rounded-full bg-primary px-4 py-2 font-medium text-on-primary transition-colors hover:bg-primary-700"
                >
                    {{ __('guest.city') }}
                </button>
                <a
                    href="#"
                    class="rounded-full bg-surface-variant px-4 py-2 font-medium text-on-surface-variant transition-colors hover:bg-outline"
                >
                    {{ __('guest.filter_house') }}
                </a>
                <a
                    href="#"
                    class="rounded-full bg-surface-variant px-4 py-2 font-medium text-on-surface-variant transition-colors hover:bg-outline"
                >
                    {{ __('guest.filter_residential') }}
                </a>
                <a
                    href="#"
                    class="rounded-full bg-surface-variant px-4 py-2 font-medium text-on-surface-variant transition-colors hover:bg-outline"
                >
                    {{ __('guest.filter_apartment') }}
                </a>
            </div>

            <div class="mt-6 flex justify-end">
                <button
                    type="submit"
                    form="guest-search-form"
                    class="flex items-center gap-2 rounded-4xl bg-primary px-6 py-3 font-semibold text-on-primary transition-colors hover:bg-primary-700"
                >
                    {{ __('guest.search_btn') }}
                </button>
            </div>
        </div>
    </div>
</section>
