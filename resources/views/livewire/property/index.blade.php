<div>
    {{-- The whole world belongs to you. --}}

    @section('action')
            <a href="{{ route('projects.create') }}" class="btn btn-primary" wire:navigate>
                New Project
            </a>
    @endsection


    <div class="grid grid-cols-4">

        {{-- property card --}}
        @forelse($properties as $property)
                <div class="bg-surface rounded-radius border border-outline p-6 shadow-sm transition-all duration-200 hover:shadow-md hover:border-outline-strong">
                    <div class="flex flex-col gap-3">
                        @if ($property->has_image)
                            <img src="{{ $property->images->first()->image_url }}" alt="{{ $property->name }}" class="w-full h-full object-cover rounded-2xl">
                        @else
                            <div class="w-full h-full bg-surface-variant rounded-radius">
                            <img src="{{ asset('assets/no_image.jpg') }}" alt="{{ $property->name }}" class="w-full h-full object-cover rounded-2xl">
                                
                            </div>
                        @endif

                        <h4 class="font-bold text-sm">{{ $property->name }}</h4>

                        <span class="text-primary text-sm font-medium">{{ $property->show_price }}</span>
                    </div>
                </div>
               
        @empty  

        @endforelse
    </div>

</div>