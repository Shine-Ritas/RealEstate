@props(['title','properties'])


<div class="container mx-auto px-4 md:px-6 lg:px-8">
    <div class="mb-3 flex flex-col gap-4 md:mb-5 md:flex-row md:items-end md:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-on-surface md:text-3xl">
                {{ __("guest.$title") }}
            </h2>
        </div>
        <a href="{{ route('properties.index') }}"
            class="shrink-0 font-semibold text-on-surface/80 underline transition-colors hover:text-primary-700">
            {{ __('guest.view_more') }}
        </a>
    </div>

    <div
        class="grid gap-6 px-6 sm:px-0 grid-cols-1  sm:grid-cols-2 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 lg:gap-8 ">
        @foreach ($properties as $property)
            <x-guest.property-display-card :property="$property" />
        @endforeach
    </div>
</div>