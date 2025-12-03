<section class="relative bg-primary-700 text-white py-12 md:py-20 lg:py-24 overflow-hidden">
    <div class="container mx-auto px-4 md:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">
            <!-- Content -->
            <div class="z-10">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4 leading-tight">
                    {{ __('guest.hero_title') }}
                </h1>
                <p class="text-lg md:text-xl text-primary-100 mb-8 leading-relaxed">
                    {{ __('guest.hero_subtitle') }}
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#" class="px-6 py-3 bg-white text-primary-700 rounded-lg hover:bg-primary-50 transition-colors font-semibold text-center">
                        {{ __('guest.btn_explore_properties') }}
                    </a>
                    <a href="#" class="px-6 py-3 border-2 border-white text-white rounded-lg hover:bg-white/10 transition-colors font-semibold text-center">
                        {{ __('guest.btn_learn_more') }}
                    </a>
                </div>
            </div>

            <!-- Image -->
            <div class="relative z-10">
                <div class="rounded-xl overflow-hidden shadow-2xl">
                    <img 
                        src="https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=800&h=600&fit=crop" 
                        alt="Modern cityscape in Thailand" 
                        class="w-full h-auto object-cover"
                    >
                </div>
            </div>
        </div>
    </div>
    
    <!-- Background decoration -->
    <div class="absolute inset-0 bg-gradient-to-br from-primary-800 to-primary-900 opacity-50"></div>
</section>

