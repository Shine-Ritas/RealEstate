<div class="flex items-center gap-3">
    {{-- Stop trying to control. --}}


        <flux:select wire:model.live="selectedPropertyStatus" class="min-w-40">
            @foreach ($propertyStatusTypes as $propertyStatusType)
                <flux:select.option value="{{ $propertyStatusType['value'] }}">
                    {{ $propertyStatusType['label'] }}
                </flux:select.option>
            @endforeach
        </flux:select>

    <div class="relative min-w-60">
        <flux:input 
            type="search" 
            wire:model.live.debounce.600ms="search"
            placeholder="Search the properties..." 
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
