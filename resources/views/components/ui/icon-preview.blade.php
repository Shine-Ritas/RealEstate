@props([
    'name' => '',
    'size' => 'size-5',
    'class' => 'text-white',
])


<i class="fa-solid fa-{{ $name }}" class="{{ $size }} {{ $class }}"></i>