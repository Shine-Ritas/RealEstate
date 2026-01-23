<div class="" x-data="preferList()">
    <x-ui.modal uid="openModal" variant="info" title="" size="xl" htitle="Manage The List" class="mx-40 text-left">
        <div class="bg-surface rounded-radius border border-outline shadow-sm min-h-full p-4 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h4 class="text-xl font-bold text-on-surface">
                    Top Listing
                </h4>
                <a href="javascript:void(0)" x-on:click="type='recommendation';openModal=true;"
                    class="text-primary hover:text-primary-700 font-semibold text-sm transition-colors hover:underline">
                    Manage
                </a>
            </div>

            @if($topProperties->count() > 0)
                <div class="relative">
                    <div class="swiper top-listing-swiper">
                        <div class="swiper-wrapper">
                            @foreach($topProperties as $property)
                                <div x-cloak class="swiper-slide">
                                    <x-property-card :property="$property" />
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-button-prev top-listing-prev !text-white bg-secondary rounded-full !mt-0 p-2">
                        </div>
                        <div class="swiper-button-next top-listing-next !text-white bg-secondary rounded-full !mt-0 p-2">
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-12 text-on-surface-variant">
                    <i class="fa fa-solid fa-home text-4xl mb-4 opacity-50"></i>
                    <p>No recommendation listings available at the moment.</p>
                </div>
            @endif
        </div>


        <div class="bg-surface rounded-radius border border-outline shadow-sm min-h-full p-4">
            <div class="flex items-center justify-between mb-6">
                <h4 class="text-xl font-bold text-on-surface">
                    Popular Properties
                </h4>
                <a href="javascript:void(0)" x-on:click="type='popular';openModal=true;"
                    class="text-primary hover:text-primary-700 font-semibold text-sm transition-colors hover:underline">
                    Manage
                </a>
            </div>

            @if($popularProperties->count() > 0)
                <div class="relative">
                    <div class="swiper top-listing-swiper">
                        <div class="swiper-wrapper">
                            @foreach($popularProperties as $property)
                                <div x-cloak class="swiper-slide">
                                    <x-property-card :property="$property" />
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-button-prev top-listing-prev !text-white bg-secondary rounded-full !mt-0 p-2">
                        </div>
                        <div class="swiper-button-next top-listing-next !text-white bg-secondary rounded-full !mt-0 p-2">
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-12 text-on-surface-variant">
                    <i class="fa fa-solid fa-home text-4xl mb-4 opacity-50"></i>
                    <p>No top listings available at the moment.</p>
                </div>
            @endif
        </div>


        <x-slot:body>
            <div class="relative">
                <div class="relative w-1/2 mb-4">
                    <flux:input type="search" placeholder="Search the properties..." x-model="search"
                        @input.debounce.600ms="handleSearch()" class="w-full" style="text-indent: 20px" />
                    <flux:icon.magnifying-glass
                        class="size-5 text-on-surface-variant absolute top-0 left-2 bottom-0 my-auto" />

                    @if($search)
                        <button type="button" wire:click="$set('search', '')"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-on-surface-variant hover:text-on-surface">
                            <flux:icon.x-mark class="size-5" />
                        </button>
                    @endif
                </div>


                <div wire:ignore x-ref="searchResultsContainer">
                    <div class="swiper top-listing-swiper-2">
                        <div class="swiper-wrapper">
                            <template x-for="property in searchProperties" :key="property.id">
                                <div class="relative swiper-slide">
                                    <div class="property-card">
                                        <img :src="property.thumbnail" class="w-full rounded-xl">
                                        <h4 x-text="property.name"></h4>
                                        <p x-text="property.price"></p>
                                    </div>
                                    <button x-on:click="$wire.togglePreference('{{ $property->id }}')"
                                        class="absolute bottom-4 right-4 btn btn-sm {{ $property->has_preference ? 'btn-success' : 'btn-primary' }}">
                                        {{ $property->has_preference ? 'Added' : 'Add' }}
                                    </button>
                                </div>
                            </template>
                        </div>
                        <div
                            class="swiper-button-prev top-listing-prev-2 !text-white bg-secondary rounded-full !mt-0 p-2">
                        </div>
                        <div
                            class="swiper-button-next top-listing-next-2 !text-white bg-secondary rounded-full !mt-0 p-2">
                        </div>
                    </div>
                </div>

            </div>
        </x-slot:body>
    </x-ui.modal>

    <script>

function initSwiper(selector, prevClass, nextClass) {
                if (typeof Swiper === 'undefined') {
                    console.error('Swiper is not loaded');
                    return null;
                }

                const container = document.querySelector(selector);
                if (!container) {
                    console.error('Container not found:', selector);
                    return null;
                }

                // Destroy if already exists
                if (container.swiper) {
                    container.swiper.update();
                }

                return new Swiper(selector, {
                    modules: [SwiperModules.Navigation],
                    slidesPerView: 1,
                    spaceBetween: 24,
                    navigation: {
                        nextEl: '.' + nextClass,
                        prevEl: '.' + prevClass,
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

        function preferList() {
            return {
                searchProperties: @js($searchProperties ?? []),
                topProperties: @js($topProperties ?? []),
                popularProperties: @js($popularProperties ?? []),
                search: '',
                type: 'recommendation',
                openModal: false,
                init() {
                    this.searchProperties = @js($searchProperties ?? []);
                    this.topProperties = @js($topProperties ?? []);
                    this.popularProperties = @js($popularProperties ?? []);
                    this.listenEvents();
                },
                loadModalData() {
                    Livewire.dispatch('loadModalData', {
                        type: type,
                        search: this.search
                    });
                },
                handleSearch() {
                    Livewire.dispatch('search-data', {
                        data:{  
                            type: this.type,
                            search: this.search
                        }
                    });
                },
                listenEvents() {
                    Livewire.on('search-properties', (data) => {
                        this.searchProperties = data;
                        initSwiper('.top-listing-swiper', 'top-listing-prev', 'top-listing-next');
                    })
                }
            }
        }

       


        document.addEventListener('DOMContentLoaded', function () {

            

            function initAllSwipers() {
                setTimeout(function () {
                    initSwiper('.top-listing-swiper', 'top-listing-prev', 'top-listing-next');
                    initSwiper('.top-listing-swiper-2', 'top-listing-prev-2', 'top-listing-next-2');
                }, 100);
            }

            // Initial load
            initAllSwipers();

            // After Livewire updates
            if (typeof Livewire !== 'undefined') {
                // Listen for custom refresh event
                window.addEventListener('refreshSwiper', function () {
                    initAllSwipers();
                });

                window.addEventListener('livewire:navigated', () => {
                    initAllSwipers();
                });

                
            }
        });
    </script>
</div>