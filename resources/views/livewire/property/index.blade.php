<div>
    {{-- The whole world belongs to you. --}}

    @section('action')
            <a href="{{ route('projects.create') }}" class="btn btn-primary" wire:navigate>
                New Project
            </a>
    @endsection


    <div class="grid grid-cols-4 gap-4">

        {{-- property card --}}
        @forelse($properties as $property)
                <div class="bg-surface rounded-radius border border-outline px-6 py-3 shadow-sm transition-all duration-200 hover:shadow-md hover:border-outline-strong">
                    <div class="flex flex-col gap-3">
                        <div class="flex justify-between items-center text-xs font-bold">
                            <div class="">
                            </div>
                            <div class="flex items-center gap2">
                                <i class="fa fa-solid fa-calendar"></i>
                                {{ $property->created_at->format('d M Y') }}
                            </div>
                        </div>
                        @if ($property->has_image)
                            <img src="{{ $property->images->first()->image_url }}" alt="{{ $property->name }}" class="w-full h-full object-cover rounded-2xl">
                        @else
                            <div class="w-full h-full bg-surface-variant rounded-radius">
                            <img src="{{ asset('assets/no_image.jpg') }}" alt="{{ $property->name }}" class="w-full h-full object-cover rounded-2xl">
                                
                            </div>
                        @endif

                        <h4 class="font-bold text-sm">{{ $property->name }}</h4>

                        <div class="flex gap-2 text-sm font-medium items-center">
                            <i class="fa fa-solid fa-city text-md "></i>

                            {{ $property->province?->p_name }} ,
                            {{ $property->district?->d_name }} ,
                            {{ $property->subdistrict?->s_name }}
                        </div>

                        <div class="flex justify-between items-center text-sm">
                            <span class="text-primary text-sm font-medium">{{ $property->show_price }}</span>

                            <div class="flex items-center gap-3 font-bold text-primary">
                                <span>
                                    {{$property->detail?->bedrooms}} <i class="fa fa-solid fa-bed"></i>
                                </span>

                                <span>
                                    {{$property->detail?->bathrooms}} <i class="fa fa-solid fa-bath"></i>
                                </span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <a href="#" class="btn btn-success">
                                <i class="fa fa-solid fa-photo-film"></i>
                            </a> 
                            <a href="#" class="btn btn-success">
                                <i class="fa-solid fa-building-circle-arrow-right"></i>
                            </a>
                            <a href="#" class="btn btn-success">
                                <i class="fa-solid fa-address-book"></i>
                            </a>
                            <a href="#" class="btn btn-danger">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                            
                        </div>

                        
                    </div>
                </div>
               
        @empty  

        @endforelse
    </div>

</div>