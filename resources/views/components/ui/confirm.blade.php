@props([
    'show' => false,
    'title' => 'Confirm Action',
    'message' => 'Are you sure you want to perform this action?',
    'confirmText' => 'Confirm',
    'cancelText' => 'Cancel',
    'variant' => 'danger',
])

<div
    x-data="{ show: @js($show) }"
    x-show="show"
    x-on:open-confirm.window="show = true"
    x-on:close-confirm.window="show = false"
    x-on:keydown.escape.window="show = false"
    style="display: none;"
    class="fixed inset-0 z-50 overflow-y-auto"
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
            class="relative transform overflow-hidden rounded-radius bg-surface text-left shadow-xl transition-all max-w-md w-full"
            x-on:click.stop
        >
            <div class="px-6 py-4">
                <h3 class="text-lg font-semibold text-on-surface mb-2">
                    {{ $title }}
                </h3>
                <p class="text-sm text-on-surface-variant">
                    {{ $message }}
                </p>
            </div>

            <div class="border-t border-outline bg-surface-variant px-6 py-4 flex items-center justify-end gap-3">
                <x-ui.button
                    variant="secondary"
                    x-on:click="show = false"
                >
                    {{ $cancelText }}
                </x-ui.button>
                <x-ui.button
                    variant="{{ $variant }}"
                    x-on:click="$dispatch('confirmed'); show = false;"
                >
                    {{ $confirmText }}
                </x-ui.button>
            </div>
        </div>
    </div>
</div>

