<div>


    @section('action')
        <div class="flex items-center gap-4">

            <x-ui.button variant="primary" icon="plus"
                onclick="window.dispatchEvent(new CustomEvent('open-facility-form', { detail: {} }))">
                Create Facility
            </x-ui.button>
        </div>
    @endsection


    <div class="flex justify-between mb-3">
        <div class=""></div>
        <div class="relative w-64">
            <flux:input type="search" wire:model.live.debounce.300ms="search"
                placeholder="Search facilities by name or description..." class="w-full " style="text-indent: 20px" />
            <flux:icon.magnifying-glass class="size-5 text-on-surface-variant absolute top-0 left-2 bottom-0 my-auto" />
            @if($search)
                <button type="button" wire:click="$set('search', '')"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-on-surface-variant hover:text-on-surface">
                    <flux:icon.x-mark class="size-5" />
                </button>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @forelse($facilities as $facility)
            <div
                class="bg-surface rounded-radius border border-outline px-6 py-3 shadow-sm transition-all duration-200 hover:shadow-md hover:border-outline-strong">
                <div class=" flex gap-4 mb-4">
                    <div class="flex size-12 items-center justify-center rounded-lg bg-primary/80 text-white">
                        <x-ui.icon-preview :name="$facility->icon" size="size-8" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <h3 class="text-md font-semibold text-on-surface">{{ $facility->name }}</h3>
                        <h3 class="text-sm text-on-surface-variant">{{ Str::words($facility->description ?? 'No description', 4) }}</h3>
                    </div>
                </div>

                <div class="mt-4 flex flex-wrap items-center gap-2 justify-end">
                    <button type="button" class="btn btn-sm btn-outline shadow-sm" 
                    onclick="window.dispatchEvent(new CustomEvent('open-facility-form', { detail: { facilityId: {{ $facility->id }} } }))">
                        <flux:icon.pencil class="size-4" />
                    </button>
                    <button type="button" class="btn btn-sm btn-danger shadow-sm" wire:click="openDeleteModal({{ $facility->id }})">
                        <flux:icon.trash class="size-4" />
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <x-ui.card>
                    <div class="py-12 text-center">
                        <flux:icon.sparkles class="mx-auto size-12 text-on-surface-variant" />
                        <h3 class="mt-4 text-lg font-semibold text-on-surface">No facilities found</h3>
                        <p class="mt-2 text-sm text-on-surface-variant">Get started by creating a new facility.</p>
                        <div class="mt-6">
                            <x-ui.button variant="primary" icon="plus"
                                onclick="window.dispatchEvent(new CustomEvent('open-facility-form', { detail: {} }))">
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

    <div x-data x-show="$wire.showDeleteModal" x-on:keydown.escape.window="$wire.closeDeleteModal()"
        style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div x-show="$wire.showDeleteModal" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/50 transition-opacity"
            x-on:click="$wire.closeDeleteModal()"></div>

        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div x-show="$wire.showDeleteModal" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative transform overflow-hidden rounded-radius bg-surface text-left shadow-xl transition-all max-w-md w-full"
                x-on:click.stop>
                <div class="px-6 py-4">
                    <h3 class="text-lg font-semibold text-on-surface mb-2">
                        Delete Facility
                    </h3>
                    <p class="text-sm text-on-surface-variant">
                        @if($facilityToDelete)
                            Are you sure you want to delete the facility "<strong>{{ $facilityToDelete->name }}</strong>"?
                            This action cannot be undone.
                        @endif
                    </p>
                </div>

                <div class="border-t border-outline bg-surface-variant px-6 py-4 flex items-center justify-end gap-3">
                    <x-ui.button variant="secondary" x-on:click="$wire.closeDeleteModal()">
                        Cancel
                    </x-ui.button>
                    <x-ui.button variant="danger" wire:click="deleteFacility">
                        Delete
                    </x-ui.button>
                </div>
            </div>
        </div>
    </div>
</div>