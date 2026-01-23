<x-ui.accordian title="{{ $content->label }}" class="relative h-full" icon="file-text">
    <form wire:submit="save">
        <div class="grid gap-6 lg:grid-cols-3 mb-3">
            <x-ui.input label="English" name="en" wire:model.live="en"
            value="{{ $content->en }}"
                placeholder="e.g., Luxury Condominium" required :error="$errors->first('en')" bold />
            <x-ui.input label="Thai" name="th" wire:model.live="th"
                value="{{ $content->th }}"
                placeholder="e.g., Luxury Condominium" required :error="$errors->first('th')" bold />
            <x-ui.input label="Myanmar" name="my" wire:model.live="my"
                value="{{ $content->my }}"
                placeholder="e.g., Luxury Condominium" required :error="$errors->first('my')" bold />
            <x-ui.input label="Chinese" name="zh" wire:model.live="zh"
                value="{{ $content->zh }}"
                placeholder="e.g., Luxury Condominium" required :error="$errors->first('zh')" bold />
        </div>

        <x-ui.button type="submit" variant="primary" class="w-full">Save</x-ui.button>
    </form>
</x-ui.accordian>