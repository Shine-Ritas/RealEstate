<div class="relative w-64">
    <flux:input 
        type="search" 
        wire:model.live.debounce.300ms="search"
        placeholder="Search social links..." 
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