@props(['icon' => null, 'class' => ''])

@if($icon == 'line')
    <i class="fa-brands fa-{{ $icon }} {{ $class }}"></i>
@else
    <i class="fa-solid fa-{{ $icon }} {{ $class }}"></i>
@endif