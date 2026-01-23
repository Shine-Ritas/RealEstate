<div class="relative" x-data="{ open: false }">
    <!-- Current Language Button -->
    <button
        @click="open = !open"
        class="flex items-center gap-2 px-3 py-2 rounded-radius  transition-colors"
    >
        <span class="text-2xl">{{ $languages[$currentLocale]['flag'] ?? '🌐' }}</span>
        <span class="hidden md:inline font-medium text-sm ">
            {{ $languages[$currentLocale]['native'] ?? 'Language' }}
        </span>
        <svg class="w-4 h-4 " fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <!-- Dropdown Menu -->
    <div
        x-show="open"
        @click.away="open = false"
        x-transition
        class="absolute -right-8 mt-5 w-48 
        glass-bg
        rounded-radius shadow-lg overflow-hidden z-60
             flex flex-col divide-y-2 divide-gray-400/20
        "
    >
        @foreach ($languages as $code => $lang)
            <button
                wire:click="switchLanguage('{{ $code }}')"
                class="w-full flex bg-glass items-center gap-3 px-4 py-3 hover-glass text-on-primary transition-colors text-left bg-gray-500/20
                
                {{ $currentLocale === $code ? '' : ' ' }}"
            >
                <span class="text-2xl">{{ $lang['flag'] }}</span>
                <div>
                    <div class="font-medium">{{ $lang['native'] }}</div>
                    <div class="text-xs opacity-80">{{ $lang['name'] }}</div>
                </div>
                @if($currentLocale === $code)
                    <svg class="ml-auto w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    
                @endif
            </button>
        @endforeach
    </div>
</div>