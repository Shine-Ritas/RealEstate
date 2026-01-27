@props(['property'])

<article
class=" rounded-radius border border-gray-300 bg-surface shadow-xl transition-shadow hover:shadow-md w-full">
<div style="background-image: url({{$property->primary_image}});"
    class="relative w-full h-72 bg-cover bg-center bg-no-repeat flex flex-col justify-end pb-4 px-4 rounded-radius">

    <span
        class="absolute left-4 top-4 rounded-full bg-white px-3 py-1 text-xs font-semibold text-black capitalize">
        {{ $property->listing_type }}
    </span>

    <div
        class="flex flex-col gap-1 py-2 text-sm text-on-surface drop-shadow-md bg-white w-full rounded-radius px-3 ">
        <div class="flex flex-col  justify-center ">
            <div class="flex justify-between items-center">
                <h3 class="mb-1 text-md font-semibold  w-2/3 overflow-hidden">
                    {{ $property->name }}
                </h3>

                <div class="flex items-center gap-1 text-muted text-xs whitespace-nowrap font-medium">
                    @if($property->detail && isset($property->detail->land_size_sqm))
                        <span class="flex items-center gap-1">
                            <i class="fa fa-solid fa-ruler-combined"></i>
                            {{ number_format($property->detail->land_size_sqm) }} sqm
                        </span>
                    @endif

                    @if($property->detail && isset($property->detail->bedrooms))
                        <span class="flex items-center gap-1">
                            <i class="fa fa-solid fa-bed"></i>
                            {{ $property->detail->bedrooms }} Bed
                        </span>
                    @endif
                </div>
            </div>
            <p class="text-xs  font-medium">
                <i class="fa fa-solid fa-location-dot text-blue-700"></i>
                {{ $property->province->p_name }} ,
                {{ $property->subdistrict->s_name }}
            </p>
        </div>

        {{-- dive --}}
        <div class="divider m-0"></div>

        <div class="flex items-center ">
            <p class=" font-semibold ">{{ $property->normal_show_price }}</p>&nbsp;
            <span class="text-xs  text-muted font-semibold">
                {{ $property->show_price_period }}
            </span>
        </div>
    </div>
</div>

</article>