<section id="faq" class="bg-white py-16 md:py-20 lg:py-24">
    <div class="container mx-auto px-4 md:px-6 lg:px-8">
        <h2 class="mb-12 text-3xl font-bold text-on-surface md:text-4xl">
            {{ __('guest.faq_title') }}
        </h2>

        <div class="mx-auto max-w-3xl space-y-3" x-data="{ open: 1 }">
            @foreach ([1, 2, 3, 4, 5] as $i)
                <div class="overflow-hidden rounded-radius border border-outline bg-surface">
                    <button
                        type="button"
                        class="flex w-full items-center justify-between px-6 py-4 text-left font-medium text-on-surface transition-colors hover:bg-surface-variant"
                        @click="open = open === {{ $i }} ? null : {{ $i }}"
                        :aria-expanded="open === {{ $i }}"
                    >
                        <span>{{ __("guest.faq_q{$i}") }}</span>
                        <svg
                            class="h-5 w-5 shrink-0 transition-transform"
                            :class="open === {{ $i }} ? 'rotate-180' : ''"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open === {{ $i }}" x-collapse x-cloak>
                        <div class="border-t border-outline px-6 py-4 text-on-surface-variant">
                            {{ __("guest.faq_a{$i}") }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
