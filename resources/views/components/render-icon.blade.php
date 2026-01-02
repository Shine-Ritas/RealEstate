@props(['icon' => null, 'class' => '','prefix' => 'fa-solid'])

@if($icon == 'line')
    <i class="fa-brands fa-{{ $icon }} {{ $class }}"></i>
@else
    <i class="{{ $prefix }} fa-{{ $icon }} {{ $class }}"></i>
@endif