<section class="hero-bg relative flex h-[100vh] flex-col overflow-hidden justify-between pb-10 ">
    <x-guest.header />
    
    <div class="hero-overlay absolute inset-0" aria-hidden="true"></div>

   <div class="flex flex-col gap-4">
    <div class="container relative z-10 mx-auto px-4  pb-32 md:px-6 md:pt-32 lg:px-8">
        <div class="text-left">
            <div class="mb-2 flex flex-wrap justify-start gap-2">
                <a href="#"
                    class="rounded-full bg-white text-on-surface px-4 py-2 text-sm font-medium transition-colors hover:bg-white/30 hover-glass">
                    {{ __('guest.filter_house') }}
                </a>
                <a href="#"
                    class="rounded-full bg-white text-on-surface px-4 py-2 text-sm font-medium  transition-colors hover:bg-white/30 hover-glass">
                    {{ __('guest.filter_apartment') }}
                </a>
                <a href="#"
                    class="rounded-full bg-white text-on-surface px-4 py-2 text-sm font-medium transition-colors hover:bg-white/30 hover-glass">
                    {{ __('guest.filter_residential') }}
                </a>
            </div>

            <h1 class="font-barlow-condensed  text-4xl font-normal leading-tight text-white md:text-5xl lg:text-6xl w-full md:max-w-2xl whitespace-normal">
                {{ __('guest.hero_title') }}
            </h1>
            {{-- <p class="mx-auto max-w-2xl text-lg text-gray-300 md:text-xl">
                {{ __('guest.hero_subtitle') }}
            </p> --}}
        </div>
    </div>
    <x-guest.search-bar />
   </div>

</section>