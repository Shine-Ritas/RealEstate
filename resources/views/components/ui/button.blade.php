@props([
    'variant' => 'primary',
    'type' => 'button',
    'icon' => null,
    'iconPosition' => 'left',
])

@php
    $baseClasses = 'inline-flex  cursor-pointer items-center justify-center gap-2 rounded-radius px-4 py-2 text-sm font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';
    
    $variantClasses = match($variant) {
        'primary' => 'bg-primary text-on-primary hover:bg-primary-700 focus:ring-primary',
        'secondary' => 'bg-surface-variant text-on-surface border border-outline hover:bg-surface hover:border-outline-strong focus:ring-primary',
        'danger' => 'bg-danger text-on-danger hover:bg-red-600 focus:ring-danger',
        'icon-button' => 'p-2 bg-surface-variant text-on-surface hover:bg-surface border border-outline focus:ring-primary',
        default => 'bg-primary text-on-primary hover:bg-primary-700 focus:ring-primary',
    };
    
    $classes = $baseClasses . ' ' . $variantClasses;
    $hasHref = $attributes->has('href');
    $tag = $hasHref ? 'a' : 'button';
@endphp

<{{ $tag }} {{ $hasHref ? '' : 'type="' . $type . '"' }} {{ $attributes->merge(['class' => $classes]) }}>
    @if($icon && $iconPosition === 'left')
        @if($icon === 'plus')
            <flux:icon.plus class="size-4" />
        @elseif($icon === 'pencil')
            <flux:icon.pencil class="size-4" />
        @elseif($icon === 'trash')
            <flux:icon.trash class="size-4" />
        @elseif($icon === 'cog-6-tooth')
            <flux:icon.cog-6-tooth class="size-4" />
        @elseif($icon === 'arrow-left')
            <flux:icon.arrow-left class="size-4" />
        @elseif($icon === 'check')
            <flux:icon.check class="size-4" />
        @else
            <flux:icon :name="$icon" class="size-4" />
        @endif
    @endif
    
    <span>{{ $slot }}</span>
    
    @if($icon && $iconPosition === 'right')
        @if($icon === 'plus')
            <flux:icon.plus class="size-4 " />
        @elseif($icon === 'pencil')
            <flux:icon.pencil class="size-4" />
        @elseif($icon === 'trash')
            <flux:icon.trash class="size-4" />
        @elseif($icon === 'cog-6-tooth')
            <flux:icon.cog-6-tooth class="size-4" />
        @elseif($icon === 'arrow-left')
            <flux:icon.arrow-left class="size-4" />
        @elseif($icon === 'check')
            <flux:icon.check class="size-4" />
        @else
            <flux:icon :name="$icon" class="size-4" />
        @endif
    @endif
</{{ $tag }}>

