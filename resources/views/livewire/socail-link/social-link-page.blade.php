<div>
    @section('action')
        <div class="flex items-center gap-4">
        <livewire:social-link.social-link-filter />

        
            <x-ui.button variant="primary" icon="plus" wire:navigate href="{{ route('social-links.create') }}">
                Create Social Link
            </x-ui.button>
        </div>
    @endsection

    <div class="flex justify-between mb-6">
        <div></div>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @forelse($socialLinks as $socialLink)
            <div class="bg-surface rounded-radius border border-outline px-6 py-4 shadow-sm transition-all duration-200 hover:shadow-md hover:border-outline-strong">
                <div class="flex gap-4 mb-4">
                    <div class="flex size-12 items-center justify-center rounded-lg text-white shrink-0
                        {{ $socialLink->photo_url ? 'bg-transparent' : 'bg-primary/80' }}">
                        @if($socialLink->photo_url)
                            <img 
                                src="{{ Storage::url($socialLink->photo_url) }}" 
                                alt="{{ $socialLink->name }}"
                                class="h-12 w-12 object-cover rounded-lg"
                            >
                        @elseif($socialLink->icon)
                            <x-render-icon :icon="$socialLink->icon" prefix="fa-brands" size="size-6" />
                        @else
                            <flux:icon.link class="size-6" />
                        @endif
                    </div>
                    <div class="flex flex-col gap-1 min-w-0 flex-1">
                       <div class="flex items-center gap-2">
                        <h3 class="text-md font-semibold text-on-surface truncate">{{ $socialLink->name }}</h3>
                        <a 
                            href="{{ $socialLink->getContactUrl() }}" 
                            @if(!$socialLink->isPhone()) target="_blank" rel="noopener noreferrer" @endif
                            class="text-sm text-primary hover:text-primary-700 truncate"
                        >
                                <i class="fa-solid fa-link"></i>
                        </a>
                       </div>
                        <div class="flex items-center gap-2 mt-1">
                            @if($socialLink->status === 'active')
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-success/10 text-success">
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-on-surface-variant/10 text-on-surface-variant">
                                    Inactive
                                </span>
                            @endif
                        </div>
                    </div>


                <div class="mt-4 flex flex-wrap items-center gap-2 justify-end">
                    <a 
                        href="{{ route('social-links.edit', $socialLink) }}" 
                        wire:navigate
                        class="btn btn-sm btn-outline shadow-sm"
                    >
                        <flux:icon.pencil class="size-3" />
                    </a>
                    <button 
                        type="button" 
                        class="btn btn-sm btn-danger shadow-sm" 
                        wire:click="openDeleteModal({{ $socialLink->id }})"
                    >
                        <flux:icon.trash class="size-3" />
                    </button>
                </div>
                </div>

            </div>
        @empty
            <div class="col-span-full">
                <x-ui.card>
                    <div class="py-12 text-center">
                        <flux:icon.sparkles class="mx-auto size-12 text-on-surface-variant" />
                        <h3 class="mt-4 text-lg font-semibold text-on-surface">No social links found</h3>
                        <p class="mt-2 text-sm text-on-surface-variant">
                            @if($search)
                                No social links match your search criteria.
                            @else
                                Get started by creating a new social link.
                            @endif
                        </p>
                        @if(!$search)
                            <div class="mt-6">
                                <x-ui.button variant="primary" icon="plus" wire:navigate href="{{ route('social-links.create') }}">
                                    Create Social Link
                                </x-ui.button>
                            </div>
                        @endif
                    </div>
                </x-ui.card>
            </div>
        @endforelse
    </div>

    @if($socialLinks->hasPages())
        <div class="mt-6">
            {{ $socialLinks->links() }}
        </div>
    @endif

    {{-- Delete Confirmation Modal --}}
    <div 
        x-data 
        x-show="$wire.showDeleteModal" 
        x-on:keydown.escape.window="$wire.closeDeleteModal()"
        style="display: none;" 
        class="fixed inset-0 z-50 overflow-y-auto" 
        role="dialog" 
        aria-modal="true"
    >
        <div 
            x-show="$wire.showDeleteModal" 
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0" 
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200" 
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" 
            class="fixed inset-0 bg-black/50 transition-opacity"
            x-on:click="$wire.closeDeleteModal()"
        ></div>

        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div 
                x-show="$wire.showDeleteModal" 
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
                        Delete Social Link
                    </h3>
                    <p class="text-sm text-on-surface-variant">
                        @if($socialLinkToDelete)
                            Are you sure you want to delete the social link "<strong>{{ $socialLinkToDelete->name }}</strong>"?
                            This action cannot be undone.
                        @endif
                    </p>
                </div>

                <div class="border-t border-outline bg-surface-variant px-6 py-4 flex items-center justify-end gap-3">
                    <x-ui.button variant="secondary" x-on:click="$wire.closeDeleteModal()">
                        Cancel
                    </x-ui.button>
                    <x-ui.button variant="danger" wire:click="deleteSocialLink">
                        Delete
                    </x-ui.button>
                </div>
            </div>
        </div>
    </div>
</div>