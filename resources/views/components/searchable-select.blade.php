@props([
    'id' => null,
    'name' => null,
    'placeholder' => 'Select an option',
    'options' => [], // [['value'=>1,'label'=>'A'], ...]
    'model' => null,
    'disabled' => false,
    'event' => null,
])

<div

    x-data="{
        open: false,
        search: '',
        selectedLabel: '',
        options: @js($options),
        currentValue: null,

        init() {
        @if($model)
            this.currentValue = $wire.get('{{ $model }}');
            this.updateSelectedLabel();

            $wire.$watch('{{ $model }}', (value) => {
                this.currentValue = value;
                this.updateSelectedLabel();
                this.open = false; // ✅ close on model change
            });

        @if($event)
            window.addEventListener('{{ $event }}', (event) => {
                this.open = false;
                this.search = '';
                this.options = event.detail.options;
                this.currentValue = null;
                this.selectedLabel = '';
            });
        @endif
        @endif
        },

        updateSelectedLabel() {
            if (this.currentValue !== null && this.currentValue !== '' && this.options.length > 0) {
                const selected = this.options.find(o => {
                    // Handle both string and number comparisons
                    return o.value == this.currentValue || o.value === this.currentValue;
                });
                if (selected) {
                    this.selectedLabel = selected.label;
                } else {
                    this.selectedLabel = '';
                }
            } else {
                this.selectedLabel = '';
            }
        },

        filteredOptions() {
            if (this.search === '') return this.options;
            return this.options.filter(o =>
                o.label.toLowerCase().includes(this.search.toLowerCase())
            );
        },

        select(option) {
            this.selectedLabel = option.label;
            this.currentValue = option.value;
            this.search = '';
            this.$nextTick(() => {
                this.open = false; // ✅ ensure close AFTER DOM update
            });
            @if($model)
                $wire.set('{{ $model }}', option.value);
            @endif
        }
    }"
    class="relative w-full"
>
    <!-- Hidden input for normal form submit -->
    <input type="hidden" name="{{ $name }}" id="{{ $id }}"
        @if($model)
            wire:model.live="{{ $model }}"
        @endif
    >

    <!-- Trigger -->
    <button
        type="button"
        @click="open = !open"
        @if ($disabled)
        disabled
        @endif
        class="w-full bg-surface border border-outline rounded-radius px-3 py-2
        flex items-center justify-between
        text-left text-on-surface focus:outline-none focus:ring-2
        focus:ring-primary focus:ring-offset-2 transition-all duration-200
        hover:border-outline-strong disabled:opacity-50 disabled:cursor-not-allowed"
    >
    
        <span x-text="selectedLabel || '{{ $placeholder }}'" :class="selectedLabel ? 'text-on-surface font-normal text-sm' : 'text-on-surface/60'"></span>

        <i
        class="fa fa-solid transition-transform duration-200 "
        :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"
    ></i>
    </button>

    <!-- Dropdown -->
    <div
        x-show="open"
        x-transition
        @click.away="open = false"
        class="absolute z-50 mt-1 w-full bg-surface border border-outline rounded-radius shadow-lg"
    >
        <!-- Search -->
        <input
            type="text"
            x-model="search"
            @click.stop
            placeholder="Search..."
            class="w-full px-3 py-2 border-b border-outline bg-surface text-on-surface focus:outline-none focus:ring-2 focus:ring-primary rounded-t-radius"
        >

        <!-- Options -->
        <ul class="max-h-60 overflow-y-auto text-sm font-medium">
            <template x-for="option in filteredOptions()" :key="option.value">
                <li
                    @click.stop="select(option)"
                    class="px-3 py-2 cursor-pointer hover:bg-surface-variant text-on-surface transition-colors duration-150"
                    :class="currentValue == option.value ? 'bg-surface-variant' : ''"
                    x-text="option.label"
                ></li>
            </template>

            <li
                x-show="filteredOptions().length === 0"
                @click.stop
                class="px-3 py-2 text-sm text-on-surface/60"
            >
                No results found
            </li>
        </ul>
    </div>

    {{-- error handling --}}
    @if($errors->has($name))
        <div class="text-sm text-danger">
            {{ $errors->first($name) }}
        </div>
    @endif
</div>
