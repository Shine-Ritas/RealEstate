@props([
    'for' => null,
    'label' => null,
    'required' => false,
    'bold' => false,
])

<label for="{{ $for }}" class="text-sm  text-on-surface {{$bold ? 'font-bold' : 'font-medium'}}">
    {{ __($label) }}
    @if($required)
        <span class="text-danger">*</span>
    @endif
</label>