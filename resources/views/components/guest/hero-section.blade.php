<section  class="bg-custom text-white overflow-hidden min-h-[100vh] relative mb-10">


    <div class="container mx-auto px-4 md:px-6 lg:px-8 mt-20 relative h-[80vh] ">
        <svg id="glass-lines" class="glass-lines"></svg>

        <div class="flex items-center h-full  ">
            <!-- Content -->
            <div class="z-40 my-auto  px-4 py-7 max-w-2xl bg-glass rounded-xl shadow-2xl" id="heroTitle">
                @php
$words = explode(' ', __('guest.hero_title'));
                @endphp
            
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-2 leading-14">
                    @foreach ($words as $i => $word)
                        @if ($i === 2 || $i === 3)
                            <span class="text-neon-primary">{{ $word }}</span>
                        @else
                            {{ $word }}
                        @endif
                        {{-- keep spacing --}}
                        @if (!$loop->last) {{ ' ' }} @endif
                    @endforeach
                </h1>
            
                <p class="text-lg text-gray-300 mb-6 leading-normal max-w-md">
                    {{ __('guest.hero_subtitle') }}
                </p>
                <div class="flex flex-col text-sm sm:flex-row gap-4 bg-white rounded-t-lg w-80 h-10 text-muted font-bold items-center justify-between px-3  border-b-2 border-white/90">
                    <a href="#" class="hover:text-neon-primary">{{ __('guest.nav_buy') }}</a>
                    <a href="#" class="hover:text-neon-primary">{{ __('guest.nav_rent') }}</a>
                    <a href="#" class="hover:text-neon-primary">{{ __('guest.nav_sell') }}</a>
                    <a href="#" class="hover:text-neon-primary">{{ __('guest.nav_projects') }}</a>
                </div>
                <div class=" bg-white  rounded-b-lg rounded-tr-lg text-muted font-bold grid grid-cols-4 divide-x-2 divide-muted py-3 justify-between text-sm">
                    <div class="flex flex-col items-center justify-center">
                        <label for="search_property_type">{{ __('guest.location') }}</label>

                        <span class="text-black">Youcenosi</span>
                    </div>

                    <div class="flex flex-col items-center justify-center">
                        <label for="search_property_type">{{ __('guest.type') }}</label>

                        <span class="text-black">Youcenosi</span>
                    </div>

                    <div class="flex flex-col items-center justify-center">
                        <label for="search_property_type">{{ __('guest.average_price') }}</label>

                        <span class="text-black">Youcenosi</span>
                    </div>

                    <div class="flex flex-col items-center justify-center">
                            <button class="btn btn-sm !bg-neon-primary text-white  hover:!bg-neon-primary/80 w-28 h-10" >
                                Search
                            </button>
                    </div>

                </div>
            </div>

            <!-- Image -->
            <div class="absolute right-10 z-10 l" id="heroImage">
                <div class=" overflow-hidden shadow-2xl rounded-xl">
                    <img 
                        src="https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=800&h=600&fit=crop" 
                        alt="Modern cityscape in Thailand" 
                        class="object-cover w-[1000px] h-[600px] rounded-xl "
                    >
                </div>
            </div>

            <div class="absolute bg-glass w-40 h-40 z-60 bottom-12 -right-0 rounded-2xl shadow-2xl">

            </div>
        </div>
    </div>
    
    <!-- Background decoration -->


    <script>
        const svg = document.getElementById("glass-lines");
        
        function drawLines(fromId, toId) {
            const from = document.getElementById(fromId);
            const to = document.getElementById(toId);
        
            if (!from || !to) return;
        
            svg.innerHTML = "";
        
            const containerRect = svg.parentElement.getBoundingClientRect();
            const f = from.getBoundingClientRect();
            const t = to.getBoundingClientRect();
        
            // convert viewport → container coords
            const fx = f.left  - containerRect.left;
            const fy = f.top   - containerRect.top;
            const fr = f.right - containerRect.left;
            const fb = f.bottom - containerRect.top;

            const tx = t.left  - containerRect.left;
            const ty = t.top   - containerRect.top;
            const tr = t.right - containerRect.left;
            const tb = t.bottom - containerRect.top;

        
            svg.setAttribute("width", containerRect.width);
            svg.setAttribute("height", containerRect.height);
        
            const lines = [
                { x1: fr, y1: fy, x2: tr, y2: ty },
                { x1: fx, y1: fy, x2: tx, y2: ty },
                { x1: fr, y1: fb, x2: tr, y2: tb },
                { x1: fx, y1: fb, x2: tx, y2: tb },
            ];
        
            lines.forEach((c, i) => {
                createLine(c, "glass-line-glow");
                createLine(c, "glass-line");
            });
        }
        
        function createLine(coords, className) {
            const line = document.createElementNS("http://www.w3.org/2000/svg", "line");
            line.setAttribute("x1", coords.x1);
            line.setAttribute("y1", coords.y1);
            line.setAttribute("x2", coords.x2);
            line.setAttribute("y2", coords.y2);
            line.setAttribute("class", className);
            svg.appendChild(line);
        }
        
        // // events
        // window.addEventListener("resize", () =>
        //     drawLines("heroTitle", "heroImage")
        // );
        
        // window.addEventListener("scroll", () =>
        //     drawLines("heroTitle", "heroImage"),
        //     { passive: true }
        // );
        
        // // init
        // drawLines("heroTitle", "heroImage");
        </script>
        
</section>

