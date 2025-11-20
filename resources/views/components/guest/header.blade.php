<header class="w-full bg-white dark:bg-surface border-b border-outline">
    <div class="container mx-auto px-4 md:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 md:h-20">
            <!-- Logo -->
            <div class="flex items-center gap-2">
                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="text-xl md:text-2xl font-semibold text-on-surface">{{ __('guest.app_name') }}</span>
            </div>

            <!-- Navigation -->
            <nav class="hidden md:flex items-center gap-6">
                <a href="#" class="text-on-surface-variant hover:text-primary transition-colors font-medium">{{ __('guest.nav_buy') }}</a>
                <a href="#" class="text-on-surface-variant hover:text-primary transition-colors font-medium">{{ __('guest.nav_rent') }}</a>
                <a href="#" class="text-on-surface-variant hover:text-primary transition-colors font-medium">{{ __('guest.nav_sell') }}</a>
                <a href="#" class="text-on-surface-variant hover:text-primary transition-colors font-medium">{{ __('guest.nav_projects') }}</a>
            </nav>

            <!-- Action Buttons -->
            <div class="flex items-center gap-4">
                <button class="p-2 text-on-surface-variant hover:text-primary transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </button>
                <a href="#" class="px-4 py-2 bg-primary text-on-primary rounded-lg hover:bg-primary-800 transition-colors font-medium">
                    {{ __('guest.btn_list_property') }}
                </a>
            </div>
        </div>
    </div>
</header>

