@props([
    'label' => null,
    'name' => null,
    'type' => 'text',
    'value' => null,
    'placeholder' => null,
    'required' => false,
    'error' => null,
    'bold' => false
])

<div class="grid gap-2">
    <x-ui.label for="{{ $name }}" label="{{ $label }}" required="{{ $required }}" :bold="$bold" />

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

