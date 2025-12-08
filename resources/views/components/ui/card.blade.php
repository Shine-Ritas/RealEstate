@props([
    'title' => null,
    'subtitle' => null,
    'hover' => true,
])

<div {{ $attributes->merge(['class' => 'bg-surface rounded-radius border border-outline p-6 shadow-sm transition-all duration-200' . ($hover ? ' hover:shadow-md hover:border-outline-strong' : '')]) }}>
    @if($title || $subtitle || isset($actions))
        <div class="mb-4 flex items-start justify-between gap-4">
            <div>
                @if($title)
                    <h3 class="text-lg font-semibold text-on-surface">{{ $title }}</h3>
                @endif
                @if($subtitle)
                    <p class="mt-1 text-sm text-on-surface-variant">{{ $subtitle }}</p>
                @endif
            </div>
            @isset($actions)
                <div class="flex items-center gap-2">
                    {{ $actions }}
                </div>
            @endisset
        </div>
    @endif

    <div>
        {{ $slot }}
    </div>
</div>

