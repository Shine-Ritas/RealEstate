@props(['property'])

@php
    $detail = $property?->detail;
@endphp

<div class="bg-white dark:bg-surface-variant rounded-xl p-6 md:p-8 border border-outline">
    <h2 class="text-2xl font-bold text-on-surface mb-6">{{ __('guest.property_details_title') }}</h2>

    <div class="space-y-4">
        <div class="flex justify-between items-center py-3 border-b border-outline">
            <span class="text-on-surface-variant">{{ __('guest.property_code') }}:</span>
            <span class="font-semibold text-on-surface">{{ $property?->property_code }}</span>
        </div>

        <div class="flex justify-between items-center py-3 border-b border-outline">
            <span class="text-on-surface-variant">{{ __('guest.year_built') }}:</span>
            <span class="font-semibold text-on-surface">{{ $detail?->year_built ?? '-' }}</span>
        </div>

        <div class="flex justify-between items-center py-3 border-b border-outline">
            <span class="text-on-surface-variant">Size (sqm):</span>
            <span class="font-semibold text-on-surface">{{ $detail?->size_sqm ? number_format($detail->size_sqm, 2) : '-' }}</span>
        </div>

        <div class="flex justify-between items-center py-3 border-b border-outline">
            <span class="text-on-surface-variant">Land size (sqm):</span>
            <span class="font-semibold text-on-surface">{{ $detail?->land_size_sqm ? number_format($detail->land_size_sqm, 2) : '-' }}</span>
        </div>

        <div class="flex justify-between items-center py-3 border-b border-outline">
            <span class="text-on-surface-variant">{{ __('guest.floor') }}:</span>
            <span class="font-semibold text-on-surface">{{ $detail?->floor ?? '-' }}</span>
        </div>

        <div class="flex justify-between items-center py-3 border-b border-outline">
            <span class="text-on-surface-variant">Unit:</span>
            <span class="font-semibold text-on-surface">
                {{ $detail?->unit_number ?? '-' }}{{ $detail?->number ? ' / ' . $detail->number : '' }}
            </span>
        </div>

        <div class="flex justify-between items-center py-3 border-b border-outline">
            <span class="text-on-surface-variant">Ownership:</span>
            <span class="font-semibold text-on-surface capitalize">{{ $detail?->ownership ?? '-' }}</span>
        </div>

        <div class="flex justify-between items-center py-3 border-b border-outline">
            <span class="text-on-surface-variant">Status:</span>
            <span class="font-semibold text-on-surface capitalize">{{ $detail?->status ?? '-' }}</span>
        </div>

        <div class="flex justify-between items-center py-3">
            <span class="text-on-surface-variant">{{ __('guest.listed') }}:</span>
            <span class="font-semibold text-on-surface">{{ $property?->created_at?->format('d M Y') ?? '-' }}</span>
        </div>
    </div>
</div>

