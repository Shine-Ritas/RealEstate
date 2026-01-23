<section  class="bg-primary text-white overflow-hidden min-h-[100vh] relative mb-10">


    <div class="container mx-auto px-4 md:px-6 lg:px-8 mt-20 relative h-[80vh] ">
        <svg id="glass-lines" class="glass-lines"></svg>

        <div class="flex items-center h-full  ">
            <!-- Content -->
            <div class="z-40 my-auto  px-4 py-7 max-w-2xl bg-glass rounded-xl" id="heroTitle">
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
            
                <p class="text-lg text-muted mb-6 leading-normal max-w-md">
                    {{ __('guest.hero_subtitle') }}
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#" class="px-6 py-3 bg-white text-primary-700 rounded-lg hover:bg-primary-50 transition-colors font-semibold text-center">
                        {{ __('guest.btn_explore_properties') }}
                    </a>
                    <a href="#" class="px-6 py-3 border-2 border-white text-white rounded-lg hover:bg-white/10 transition-colors font-semibold text-center">
                        {{ __('guest.btn_learn_more') }}
                    </a>
                </div>
            </div>

            <!-- Image -->
            <div class="absolute right-10 z-10 l" id="heroImage">
                <div class=" overflow-hidden shadow-2xl rounded-x">
                    <img 
                        src="https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=800&h=600&fit=crop" 
                        alt="Modern cityscape in Thailand" 
                        class="object-cover w-[1000px] h-[600px]"
                    >
                </div>
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

