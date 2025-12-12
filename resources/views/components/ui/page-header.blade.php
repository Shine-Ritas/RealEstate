@props([
    'header' => null ,
    'subtitle' => null,
    'showNotifications' => true,
    'notificationCount' => 0,
])

<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between bg-background px-8 py-4 border-b border-zinc-200">
    <!-- Title Section -->
    <div class="flex-1">
        <h1 class="text-2xl font-semibold text-on-surface">{{ $header }}</h1>
        @if($subtitle)
            <p class="mt-1 text-sm text-on-surface-variant">{{ $subtitle }}</p>
        @endif
    </div>

    <!-- Actions Section -->
    <div class="flex items-center gap-3">
        <!-- Notifications -->
        @if($showNotifications)
            <flux:dropdown position="bottom" align="end">
                <button
                    type="button"
                    class="relative flex items-center justify-center rounded-lg p-2 text-on-surface-variant transition-colors hover:bg-surface-variant dark:hover:bg-zinc-800"
                    aria-label="{{ __('Notifications') }}"
                >
                    <flux:icon.bell class="size-5" />
                    @if($notificationCount > 0)
                        <span class="absolute right-1 top-1 flex size-2 items-center justify-center">
                            <span class="absolute inline-flex size-full animate-ping rounded-full bg-danger opacity-75"></span>
                            <span class="relative inline-flex size-2 rounded-full bg-danger"></span>
                        </span>
                    @endif
                </button>

                <flux:menu class="w-80">
                    <div class="p-4">
                        <div class="flex items-center justify-between">
                            <flux:heading size="sm">{{ __('Notifications') }}</flux:heading>
                            @if($notificationCount > 0)
                                <flux:badge variant="danger" size="sm">{{ $notificationCount }}</flux:badge>
                            @endif
                        </div>
                    </div>
                    <flux:menu.separator />
                    <div class="max-h-96 overflow-y-auto p-2">
                        <div class="flex flex-col items-center justify-center py-8 text-center">
                            <flux:icon.bell class="mb-2 size-8 text-on-surface-variant" />
                            <p class="text-sm text-on-surface-variant">{{ __('No new notifications') }}</p>
                        </div>
                    </div>
                </flux:menu>
            </flux:dropdown>
        @endif


        @yield('action')

    </div>
</div>

