@props([
    'label' => null,
    'name' => null,
    'value' => null,
    'placeholder' => null,
    'required' => false,
    'rows' => 4,
    'error' => null,
])

<div class="grid gap-2">
    @if($label)
        <label for="{{ $name }}" class="text-sm font-medium text-on-surface">
            {{ $label }}
            @if($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    <flux:textarea
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        :required="$required"
        rows="{{ $rows }}"
        {{ $attributes->merge(['class' => 'w-full']) }}
    />

    @if($error)
        <p class="text-sm text-danger">{{ $error }}</p>
    @endif
</div>

