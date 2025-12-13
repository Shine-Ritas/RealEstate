@props([
    'title' => null,
    'open' => false,
])

<div
    x-data="{ isOpen: {{ $open ? 'true' : 'false' }} }"
    class="bg-surface rounded-radius border border-outline shadow-sm"
>
    <button
        type="button"
        @click="isOpen = !isOpen"
        class="w-full flex items-center justify-between collapse-title text-lg font-semibold text-on-surface"
    >
        <span>{{ $title }}</span>

        {{-- Right side content (optional) --}}
        @isset($right)
            <span class="text-sm font-medium text-primary">
                {{ $right }}
            </span>
        @endisset
    </button>

    <div
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-1"
        x-cloak
        class="space-y-6 px-4 pb-4"
    >
        {{ $slot }}
    </div>
</div>
