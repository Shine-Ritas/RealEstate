@props(['property'])

@php
    $images = collect($property?->images ?? [])
        ->filter(fn ($image) => filled($image?->image_url))
        ->sortByDesc(fn ($image) => (bool) ($image?->is_primary ?? false))
        ->values();

    $group = 'property-' . ($property?->id ?? 'gallery');

    $mainImage = $images->first()?->image_url ?? asset('assets/no_image.jpg');
    $caption = $property?->name ?? __('guest.property_details_title');

    $thumbnails = $images->take(4);
    $extraCount = max(0, $images->count() - 4);
@endphp

<div class="space-y-4">
    <div class="relative rounded-xl overflow-hidden bg-surface-variant">
        @if($images->isNotEmpty())
            <a href="{{ $mainImage }}" data-fancybox="{{ $group }}" data-caption="{{ $caption }}">
                <img
                    src="{{ $mainImage }}"
                    alt="{{ $caption }}"
                    class="w-full h-[500px] md:h-[600px] object-cover"
                >
            </a>
        @else
            <img
                src="{{ $mainImage }}"
                alt="{{ $caption }}"
                class="w-full h-[500px] md:h-[600px] object-cover"
            >
        @endif

        <span class="absolute top-4 left-4 px-3 py-1 bg-success text-on-success rounded-full text-sm font-semibold capitalize">
            {{ $property?->listing_type ?? __('guest.property_details_title') }}
        </span>
    </div>

    @if($images->isNotEmpty())
        <div class="grid grid-cols-4 gap-4">
            @foreach($thumbnails as $index => $image)
                <a
                    href="{{ $image->image_url }}"
                    data-fancybox="{{ $group }}"
                    data-caption="{{ $caption }}"
                    class="relative rounded-lg overflow-hidden bg-surface-variant aspect-square group"
                >
                    <img
                        src="{{ $image->image_url }}"
                        alt="{{ $caption }} - {{ $index + 1 }}"
                        class="w-full h-full object-cover group-hover:opacity-75 transition-opacity"
                    >

                    @if($index === 3 && $extraCount > 0)
                        <div class="absolute inset-0 bg-black/60 flex items-center justify-center text-white font-semibold">
                            +{{ $extraCount }} more
                        </div>
                    @endif
                </a>
            @endforeach
        </div>

        @if($images->count() > 4)
            <div class="hidden">
                @foreach($images->slice(4) as $image)
                    <a href="{{ $image->image_url }}" data-fancybox="{{ $group }}" data-caption="{{ $caption }}">.</a>
                @endforeach
            </div>
        @endif
    @endif
</div>

