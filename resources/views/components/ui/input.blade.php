@props([
    'label' => null,
    'name' => null,
    'type' => 'text',
    'value' => null,
    'placeholder' => null,
    'required' => false,
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

    <flux:input
        id="{{ $name }}"
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        :required="$required"
        {{ $attributes->merge(['class' => 'w-full']) }}
    />

    @if($error)
        <p class="text-sm text-danger">{{ $error }}</p>
    @endif
</div>

