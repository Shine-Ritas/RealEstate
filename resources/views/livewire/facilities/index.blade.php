<div>
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-on-surface">Facility Management</h1>
            <p class="mt-1 text-sm text-on-surface-variant">Manage property facilities and amenities</p>
        </div>
        <x-ui.button
            variant="primary"
            icon="plus"
            onclick="window.dispatchEvent(new CustomEvent('open-facility-form', { detail: {} }))"
        >
            Create Facility
        </x-ui.button>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 rounded-radius bg-success/10 border border-success/20 px-4 py-3 text-sm text-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @forelse($facilities as $facility)
            <x-ui.card
                :title="$facility->name"
                :subtitle="$facility->description ?? 'No description'"
            >
                <x-slot name="actions">
                    <div class="flex items-center gap-2">
                        @if($facility->status === 'active')
                            <span class="inline-flex items-center rounded-full bg-success/10 px-2 py-1 text-xs font-medium text-success">
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-on-surface-variant/10 px-2 py-1 text-xs font-medium text-on-surface-variant">
                                Inactive
                            </span>
                        @endif
                    </div>
                </x-slot>

                <div class="mt-4 flex items-center justify-center mb-4">
                    <div class="flex size-16 items-center justify-center rounded-lg bg-primary/10">
                        <x-ui.icon-preview :name="$facility->icon" size="size-8" />
                    </div>
                </div>

                <div class="mt-4 flex flex-wrap items-center gap-2">
                    <x-ui.button
                        variant="secondary"
                        icon="pencil"
                        icon-position="left"
                        onclick="window.dispatchEvent(new CustomEvent('open-facility-form', { detail: { facilityId: {{ $facility->id }} } }))"
                    >
                        Edit
                    </x-ui.button>
                    <x-ui.button
                        variant="danger"
                        icon="trash"
                        icon-position="left"
                        wire:click="openDeleteModal({{ $facility->id }})"
                    >
                        Delete
                    </x-ui.button>
                </div>
            </x-ui.card>
        @empty
            <div class="col-span-full">
                <x-ui.card>
                    <div class="py-12 text-center">
                        <flux:icon.sparkles class="mx-auto size-12 text-on-surface-variant" />
                        <h3 class="mt-4 text-lg font-semibold text-on-surface">No facilities found</h3>
                        <p class="mt-2 text-sm text-on-surface-variant">Get started by creating a new facility.</p>
                        <div class="mt-6">
                            <x-ui.button
                                variant="primary"
                                icon="plus"
                                onclick="window.dispatchEvent(new CustomEvent('open-facility-form', { detail: {} }))"
                            >
                                Create Facility
                            </x-ui.button>
                        </div>
                    </div>
                </x-ui.card>
            </div>
        @endforelse
    </div>

    @if($facilities->hasPages())
        <div class="mt-6">
            {{ $facilities->links() }}
        </div>
    @endif

    <livewire:facilities.form />

    <div
        x-data="{ show: @js($showDeleteModal) }"
        x-show="show"
        x-on:keydown.escape.window="show = false; $wire.closeDeleteModal()"
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
            x-on:click="show = false; $wire.closeDeleteModal()"
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
                        Delete Facility
                    </h3>
                    <p class="text-sm text-on-surface-variant">
                        @if($facilityToDelete)
                            Are you sure you want to delete the facility "<strong>{{ $facilityToDelete->name }}</strong>"? This action cannot be undone.
                        @endif
                    </p>
                </div>

                <div class="border-t border-outline bg-surface-variant px-6 py-4 flex items-center justify-end gap-3">
                    <x-ui.button
                        variant="secondary"
                        x-on:click="show = false; $wire.closeDeleteModal()"
                    >
                        Cancel
                    </x-ui.button>
                    <x-ui.button
                        variant="danger"
                        wire:click="deleteFacility"
                        x-on:click="show = false"
                    >
                        Delete
                    </x-ui.button>
                </div>
            </div>
        </div>
    </div>
</div>
