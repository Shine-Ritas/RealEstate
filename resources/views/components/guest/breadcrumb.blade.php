<nav class="bg-surface-variant dark:bg-surface border-b border-outline py-4">
    <div class="container mx-auto px-4 md:px-6 lg:px-8">
        <div class="flex items-center gap-2 text-sm text-on-surface-variant">
            <a href="/" class="hover:text-primary transition-colors">{{ __('guest.breadcrumb_home') }}</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            @if(isset($location))
                <a href="#" class="hover:text-primary transition-colors">{{ $location }}</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            @endif
            <span class="text-on-surface">{{ $current ?? __('guest.property_details_title') }}</span>
        </div>
    </div>
</nav>

