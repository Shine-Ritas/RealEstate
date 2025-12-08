@props([
    'show' => false,
    'title' => null,
    'maxWidth' => '2xl',
    'closeable' => true,
])

@php
    $maxWidthClasses = match($maxWidth) {
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
        '3xl' => 'max-w-3xl',
        '4xl' => 'max-w-4xl',
        '5xl' => 'max-w-5xl',
        '6xl' => 'max-w-6xl',
        '7xl' => 'max-w-7xl',
        default => 'max-w-2xl',
    };
@endphp

<div
    x-data="{ show: @js($show) }"
    x-show="show"
    x-on:open-modal.window="show = true"
    x-on:close-modal.window="show = false"
    x-on:keydown.escape.window="show = false"
    style="display: none;"
    class="fixed inset-0 z-50 overflow-y-auto"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true"
>
    <div
        x-show="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/50 transition-opacity"
        x-on:click="show = false"
    ></div>

    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative transform overflow-hidden rounded-radius bg-surface text-left shadow-xl transition-all {{ $maxWidthClasses }} w-full"
            x-on:click.stop
        >
            @if($title || $closeable)
                <div class="flex items-center justify-between border-b border-outline px-6 py-4">
                    @if($title)
                        <h3 class="text-lg font-semibold text-on-surface" id="modal-title">
                            {{ $title }}
                        </h3>
                    @endif
                    @if($closeable)
                        <button
                            type="button"
                            class="rounded-lg p-1 text-on-surface-variant hover:bg-surface-variant hover:text-on-surface focus:outline-none focus:ring-2 focus:ring-primary"
                            x-on:click="show = false"
                        >
                            <flux:icon.x-mark class="size-5" />
                        </button>
                    @endif
                </div>
            @endif

            <div class="px-6 py-4">
                {{ $slot }}
            </div>

            @isset($footer)
                <div class="border-t border-outline bg-surface-variant px-6 py-4">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>

