<div class="bg-white dark:bg-surface-variant rounded-xl p-6 md:p-8 border border-outline">
    <h2 class="text-2xl font-bold text-on-surface mb-6">Property Details</h2>
    <div class="space-y-4">
        <div class="flex justify-between items-center py-3 border-b border-outline">
            <span class="text-on-surface-variant">Developer:</span>
            <span class="font-semibold text-on-surface">{{ $developer ?? 'Sansiri Group' }}</span>
        </div>
        <div class="flex justify-between items-center py-3 border-b border-outline">
            <span class="text-on-surface-variant">Year Built:</span>
            <span class="font-semibold text-on-surface">{{ $yearBuilt ?? '2023' }}</span>
        </div>
        <div class="flex justify-between items-center py-3 border-b border-outline">
            <span class="text-on-surface-variant">Width:</span>
            <span class="font-semibold text-on-surface">{{ $width ?? '8.5m' }}</span>
        </div>
        <div class="flex justify-between items-center py-3 border-b border-outline">
            <span class="text-on-surface-variant">Height:</span>
            <span class="font-semibold text-on-surface">{{ $height ?? '3.2m' }}</span>
        </div>
        <div class="flex justify-between items-center py-3">
            <span class="text-on-surface-variant">Listed:</span>
            <span class="font-semibold text-on-surface">{{ $listedDate ?? 'Jan 15, 2024' }}</span>
        </div>
    </div>
</div>

