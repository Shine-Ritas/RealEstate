<div class="bg-white dark:bg-surface-variant rounded-xl p-6 md:p-8 border border-outline">
    <h2 class="text-2xl font-bold text-on-surface mb-6">{{ __('guest.property_details_title') }}</h2>
    <div class="space-y-4">
        <div class="flex justify-between items-center py-3 border-b border-outline">
            <span class="text-on-surface-variant">{{ __('guest.developer') }}:</span>
            <span class="font-semibold text-on-surface">{{ $developer ?? 'Sansiri Group' }}</span>
        </div>
        <div class="flex justify-between items-center py-3 border-b border-outline">
            <span class="text-on-surface-variant">{{ __('guest.year_built') }}:</span>
            <span class="font-semibold text-on-surface">{{ $yearBuilt ?? '2023' }}</span>
        </div>
        <div class="flex justify-between items-center py-3 border-b border-outline">
            <span class="text-on-surface-variant">{{ __('guest.width') }}:</span>
            <span class="font-semibold text-on-surface">{{ $width ?? '8.5m' }}</span>
        </div>
        <div class="flex justify-between items-center py-3 border-b border-outline">
            <span class="text-on-surface-variant">{{ __('guest.height') }}:</span>
            <span class="font-semibold text-on-surface">{{ $height ?? '3.2m' }}</span>
        </div>
        <div class="flex justify-between items-center py-3">
            <span class="text-on-surface-variant">{{ __('guest.listed') }}:</span>
            <span class="font-semibold text-on-surface">{{ $listedDate ?? 'Jan 15, 2024' }}</span>
        </div>
    </div>
</div>

