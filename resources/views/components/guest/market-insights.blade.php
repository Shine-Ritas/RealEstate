<section class="py-12 md:py-16 lg:py-20 bg-surface-variant dark:bg-surface">
    <div class="container mx-auto px-4 md:px-6 lg:px-8">
        <h2 class="text-3xl md:text-4xl font-bold text-center text-on-surface mb-10 md:mb-12">
            {{ __('guest.market_insights_title') }}
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
            <!-- Active Listings -->
            <div class="text-center">
                <div class="text-4xl md:text-5xl lg:text-6xl font-bold text-primary mb-2">
                    {{ $activeListings ?? '2,500+' }}
                </div>
                <p class="text-lg text-on-surface-variant">{{ __('guest.active_listings') }}</p>
            </div>

            <!-- Average Price -->
            <div class="text-center">
                <div class="text-4xl md:text-5xl lg:text-6xl font-bold text-primary mb-2">
                    {{ $averagePrice ?? '฿8.5M' }}
                </div>
                <p class="text-lg text-on-surface-variant">{{ __('guest.average_price') }}</p>
            </div>

            <!-- Price Growth -->
            <div class="text-center">
                <div class="text-4xl md:text-5xl lg:text-6xl font-bold text-primary mb-2">
                    {{ $priceGrowth ?? '15%' }}
                </div>
                <p class="text-lg text-on-surface-variant">{{ __('guest.price_growth_yoy') }}</p>
            </div>
        </div>
    </div>
</section>

