@props([
    'name' => '',
    'size' => 'size-5',
    'class' => 'text-primary',
])




@php
    // Use component syntax: flux:icon.{name}
    $fluxComponent = 'flux:icon.' . $name;
@endphp
<flux:icon name="{{ $name }}" class="{{ $size }} {{ $class }}" />
