<div class="flex items-center gap-4">


    <x-ui.button
    type="button" variant="primary" class="w-full" wire:click="publish">Publish</x-ui.button>

    <div class="relative min-w-60">
        

    
        <flux:input 
            type="search" 
            wire:model.live.debounce.600ms="search"
            placeholder="Search the contents..." 
            class="w-full" 
            style="text-indent: 20px" 
        />
        <flux:icon.magnifying-glass class="size-5 text-on-surface-variant absolute top-0 left-2 bottom-0 my-auto" />
        
        @if($search)
            <button 
                type="button" 
                wire:click="$set('search', '')"
                class="absolute inset-y-0 right-0 flex items-center pr-3 text-on-surface-variant hover:text-on-surface"
            >
                <flux:icon.x-mark class="size-5" />
            </button>
        @endif
    </div>

</div>
