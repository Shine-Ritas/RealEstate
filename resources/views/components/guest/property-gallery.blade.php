<div class="space-y-4">
    <!-- Main Image -->
    <div class="relative rounded-xl overflow-hidden bg-surface-variant">
        <img 
            src="{{ $mainImage ?? 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=1200&h=800&fit=crop' }}" 
            alt="{{ $propertyTitle ?? 'Property Image' }}" 
            class="w-full h-[500px] md:h-[600px] object-cover"
            id="main-property-image"
        >
        @if(isset($status))
            <span class="absolute top-4 left-4 px-3 py-1 bg-success text-on-success rounded-full text-sm font-semibold">
                {{ $status }}
            </span>
        @endif
    </div>

    <!-- Thumbnail Gallery -->
    @if(isset($thumbnails) && count($thumbnails) > 0)
        <div class="grid grid-cols-4 gap-4">
            @foreach($thumbnails as $index => $thumbnail)
                <button 
                    onclick="changeMainImage('{{ $thumbnail }}')"
                    class="relative rounded-lg overflow-hidden bg-surface-variant aspect-square group"
                >
                    <img 
                        src="{{ $thumbnail }}" 
                        alt="Property thumbnail {{ $index + 1 }}" 
                        class="w-full h-full object-cover group-hover:opacity-75 transition-opacity"
                    >
                    @if($index === 3 && isset($totalImages) && $totalImages > 4)
                        <div class="absolute inset-0 bg-primary-900/60 flex items-center justify-center text-white font-semibold">
                            +{{ $totalImages - 4 }} more
                        </div>
                    @endif
                </button>
            @endforeach
        </div>
    @else
        <!-- Default thumbnails -->
        <div class="grid grid-cols-4 gap-4">
            <button 
                onclick="changeMainImage('https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=1200&h=800&fit=crop')"
                class="relative rounded-lg overflow-hidden bg-surface-variant aspect-square group"
            >
                <img 
                    src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=300&h=300&fit=crop" 
                    alt="Property thumbnail 1" 
                    class="w-full h-full object-cover group-hover:opacity-75 transition-opacity"
                >
            </button>
            <button 
                onclick="changeMainImage('https://images.unsplash.com/photo-1556911220-bff31c812dba?w=1200&h=800&fit=crop')"
                class="relative rounded-lg overflow-hidden bg-surface-variant aspect-square group"
            >
                <img 
                    src="https://images.unsplash.com/photo-1556911220-bff31c812dba?w=300&h=300&fit=crop" 
                    alt="Property thumbnail 2" 
                    class="w-full h-full object-cover group-hover:opacity-75 transition-opacity"
                >
            </button>
            <button 
                onclick="changeMainImage('https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=1200&h=800&fit=crop')"
                class="relative rounded-lg overflow-hidden bg-surface-variant aspect-square group"
            >
                <img 
                    src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=300&h=300&fit=crop" 
                    alt="Property thumbnail 3" 
                    class="w-full h-full object-cover group-hover:opacity-75 transition-opacity"
                >
            </button>
            <button 
                onclick="changeMainImage('https://images.unsplash.com/photo-1556911220-bff31c812dba?w=1200&h=800&fit=crop')"
                class="relative rounded-lg overflow-hidden bg-surface-variant aspect-square group"
            >
                <img 
                    src="https://images.unsplash.com/photo-1556911220-bff31c812dba?w=300&h=300&fit=crop" 
                    alt="Property thumbnail 4" 
                    class="w-full h-full object-cover group-hover:opacity-75 transition-opacity"
                >
                <div class="absolute inset-0 bg-primary-900/60 flex items-center justify-center text-white font-semibold">
                    +12 more
                </div>
            </button>
        </div>
    @endif
</div>

<script>
    function changeMainImage(imageUrl) {
        document.getElementById('main-property-image').src = imageUrl;
    }
</script>

