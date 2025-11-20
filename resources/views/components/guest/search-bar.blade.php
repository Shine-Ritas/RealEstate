<section class="relative -mt-8 md:-mt-12 lg:-mt-16 z-20">
    <div class="container mx-auto px-4 md:px-6 lg:px-8">
        <div class="bg-white dark:bg-surface rounded-xl shadow-xl p-6 md:p-8 border border-outline">
            <form class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Property Type -->
                <div>
                    <label class="block text-sm font-medium text-on-surface-variant mb-2">{{ __('guest.search_property_type') }}</label>
                    <select class="w-full px-4 py-3 border border-outline rounded-lg bg-surface text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option>{{ __('guest.option_all_types') }}</option>
                        <option>{{ __('guest.property_type_condominiums') }}</option>
                        <option>{{ __('guest.property_type_houses') }}</option>
                        <option>{{ __('guest.property_type_land') }}</option>
                        <option>{{ __('guest.property_type_commercial') }}</option>
                    </select>
                </div>

                <!-- Location -->
                <div>
                    <label class="block text-sm font-medium text-on-surface-variant mb-2">{{ __('guest.search_location') }}</label>
                    <input 
                        type="text" 
                        placeholder="{{ __('guest.search_location_placeholder') }}" 
                        class="w-full px-4 py-3 border border-outline rounded-lg bg-surface text-on-surface placeholder-on-surface-variant focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                    >
                </div>

                <!-- Price Range -->
                <div>
                    <label class="block text-sm font-medium text-on-surface-variant mb-2">{{ __('guest.search_price_range') }}</label>
                    <select class="w-full px-4 py-3 border border-outline rounded-lg bg-surface text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option>{{ __('guest.option_any_price') }}</option>
                        <option>Under ฿5M</option>
                        <option>฿5M - ฿15M</option>
                        <option>฿15M - ฿30M</option>
                        <option>Over ฿30M</option>
                    </select>
                </div>

                <!-- Bedrooms -->
                <div>
                    <label class="block text-sm font-medium text-on-surface-variant mb-2">{{ __('guest.search_bedrooms') }}</label>
                    <select class="w-full px-4 py-3 border border-outline rounded-lg bg-surface text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option>{{ __('guest.option_any') }}</option>
                        <option>1+</option>
                        <option>2+</option>
                        <option>3+</option>
                        <option>4+</option>
                        <option>5+</option>
                    </select>
                </div>
            </form>

            <!-- Search Button -->
            <div class="mt-6">
                <button type="submit" class="w-full bg-primary text-on-primary py-3 rounded-lg hover:bg-primary-800 transition-colors font-semibold flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    {{ __('guest.search_btn') }}
                </button>
            </div>
        </div>
    </div>
</section>

