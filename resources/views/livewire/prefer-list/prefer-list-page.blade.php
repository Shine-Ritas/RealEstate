<div>
    <x-ui.modal uid="openModal" variant="info" title=""  size="xl" class="mx-40 text-left">
        <div class="bg-surface rounded-radius border border-outline shadow-sm min-h-full p-4">
            <div class="flex items-center justify-between mb-6">
                <h4 class="text-xl font-bold text-on-surface">
                    Top Listing
                </h4>
                <a href="javascript:void(0)" 
                 x-on:click="openModal=true;"
                class="text-primary hover:text-primary-700 font-semibold text-sm transition-colors hover:underline">
                    Manage
                </a>
            </div>

            @if($topProperties->count() > 0)
                <div class="relative">
                    <!-- Swiper -->
                    <div class="swiper top-listing-swiper">
                        <div class="swiper-wrapper">
                            @foreach($topProperties as $property)
                            <x-property-card :property="$property" />
                            @endforeach
                        </div>

                        {{-- Navigation arrows --}}
                        <div class="swiper-button-prev top-listing-prev !text-white bg-secondary   rounded-full  !mt-0  p-2"></div>
                        <div class="swiper-button-next top-listing-next !text-white bg-secondary  rounded-full  !mt-0  p-2"></div>
                    </div>
                </div>
            @else
                <div class="text-center py-12 text-on-surface-variant">
                    <i class="fa fa-solid fa-home text-4xl mb-4 opacity-50"></i>
                    <p>No top listings available at the moment.</p>
                </div>
            @endif
        </div>

        <x-slot:body >
            <div class="relative">

            <div class="swiper top-listing-swiper">
                <div class="swiper-wrapper">
                    @foreach($topProperties as $property)
                    <x-property-card :property="$property" />
                    @endforeach
                </div>

                {{-- Navigation arrows --}}
                <div class="swiper-button-prev top-listing-prev !text-white bg-secondary   rounded-full  !mt-0  p-2"></div>
                <div class="swiper-button-next top-listing-next !text-white bg-secondary  rounded-full  !mt-0  p-2"></div>
            </div>
            </div>
        </x-slot:body>
    </x-ui.modal>


    <script>

        
        document.addEventListener('livewire:init', function() {
            function initSwiper(selector) {
                if (typeof Swiper !== 'undefined' && typeof SwiperModules !== 'undefined') {
                    const swiperContainer = document.querySelector(selector);
                    if (swiperContainer && !swiperContainer.swiper) {
                        new Swiper(selector, {
                            modules: [SwiperModules.Navigation],
                            slidesPerView: 1,
                            spaceBetween: 24,
                            navigation: {
                                nextEl: '.top-listing-next',
                                prevEl: '.top-listing-prev',
                            },
                            breakpoints: {
                                640: {
                                    slidesPerView: 2,
                                    spaceBetween: 24,
                                },
                                1024: {
                                    slidesPerView: 3,
                                    spaceBetween: 24,
                                },
                            },
                            speed: 400,
                            loop: false,
                        });
                    }
                }
            }
            
            initSwiper('.top-listing-swiper');

            document.addEventListener('livewire:navigated', () => {
                initSwiper('.top-listing-swiper');
            });

            
            // Re-initialize after Livewire updates
            Livewire.hook('morph.updated', () => {
                setTimeout(initSwiper, 100);
            });
        });
    </script>
</div>