<header id="navBar" class="w-full flex justify-center px-4 md:px-6 lg:px-8 py-4 absolute top-3 left-0  z-50">
    <div class=" max-w-7xl rounded-xl
        h-full w-full bg-glass
    dark:bg-surface shadow-sm text-white">
    
        <div class="flex items-center justify-between h-16 md:h-16 px-6 md:px-8">
            <!-- Logo -->
            <div class="flex items-center gap-2">
                <svg class="w-6 h-6 text-on-glass" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="text-xl md:text-2xl font-semibold">{{ __('guest.app_name') }}</span>
            </div>

            <!-- Navigation -->
            <nav class="hidden md:flex items-center gap-6">
                <a href="#" class="guest-header-nav-link">{{ __('guest.nav_buy') }}</a>
                <a href="#" class="guest-header-nav-link">{{ __('guest.nav_rent') }}</a>
                <a href="#" class="guest-header-nav-link">{{ __('guest.nav_sell') }}</a>
                <a href="#" class="guest-header-nav-link">{{ __('guest.nav_projects') }}</a>
            </nav>

            <!-- Action Buttons -->
            <div class="flex items-center gap-3">
                <livewire:helper.language-switcher />
            </div>
        </div>
    </div>
</header>

