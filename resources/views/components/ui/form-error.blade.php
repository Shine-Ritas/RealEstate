@props([
    'message' => null,
    'name' => null,
])

@if($errors->has($name))
    <p class="text-sm text-danger">{{ $errors->first($name) }}</p>
@endif