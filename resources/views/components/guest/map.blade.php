<section class="relative py-12 md:py-20 overflow-hidden">
    <div class="container mx-auto px-4 md:px-6 lg:px-8">
        <div id="map" class="h-[60vh] w-full rounded-xl"></div>
    </div>
</section>

@push('scripts')
<script>
    let map;
    let markers = [];
    let userMarker = null;
    let mapReady = false;

    // Demo listings (replace with Livewire data later)
    const listings = [
        {
            id: 1,
            lat: 13.622819863452207,
            lng: 100.5907903283937,
            price: 18000,
            name: "Phayathai Place",
            image: "http://localhost:8050/storage/property/01ke23rpgqafffkyaegp7tw6rp/images/69592618f3451_1767450136.jpg",
            bed: 1,
            bath: 1,
            size: 40
        },
        {
            id: 2,
            lat: 13.626891962362109,
            lng: 100.58924223908704,
            price: 12000,
            name: "Phayathai Place 2",
            image: "http://localhost:8050/storage/property/01ke23rpgqafffkyaegp7tw6rp/images/6959261903421_1767450137.jpg",
            bed: 1,
            bath: 1,
            size: 40
        },
        {
            id: 3,
            lat: 13.625201882554776,
            lng: 100.59626218085631,
            price: 22000,
            name: "Phayathai Place 3",
            image: "http://localhost:8050/storage/property/01ke23rpgqafffkyaegp7tw6rp/images/6959261901129_1767450137.jpg",
            bed: 1,
            bath: 1,
            size: 40
        }
    ];

    /* ---------------------------
       MAP INITIALIZATION
    ----------------------------*/
    function initMap() {
        if (mapReady || !window.google) return;

        map = new google.maps.Map(document.getElementById("map"), {
            zoom: 14,
            center: { lat: 13.7563, lng: 100.5018 }, // Bangkok fallback
            mapId: "map" // MUST be a real Map ID in production
        });

        mapReady = true;

        locateUser();           // Center on user if allowed
        renderMarkers(listings);
    }

    /* ---------------------------
       USER LOCATION
    ----------------------------*/
    function locateUser() {
        if (!navigator.geolocation) return;

        navigator.geolocation.getCurrentPosition(
            position => {
                const userLatLng = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                map.setCenter(userLatLng);
                map.setZoom(15);

                userMarker = new google.maps.marker.AdvancedMarkerElement({
                    map,
                    position: userLatLng,
                    content: createUserDot()
                });

                // Optional: notify Livewire
                // Livewire.dispatch('userLocationUpdated', userLatLng);
            },
            () => {
                // Permission denied → fallback silently
            },
            {
                enableHighAccuracy: true,
                timeout: 8000,
                maximumAge: 60000
            }
        );
    }

    function createUserDot() {
        const div = document.createElement('div');
        div.innerHTML = `
            <div style="
                width:14px;
                height:14px;
                background:#2563eb;
                border:3px solid white;
                border-radius:9999px;
                box-shadow:0 0 10px rgba(37,99,235,.8);
            "></div>
        `;
        return div.firstElementChild;
    }

    /* ---------------------------
       PROPERTY MARKERS
    ----------------------------*/
    function clearMarkers() {
        markers.forEach(m => m.map = null);
        markers = [];
    }

    function renderMarkers(items) {
        if (!mapReady) return;

        clearMarkers();

        items.forEach(item => {
            const marker = new google.maps.marker.AdvancedMarkerElement({
                map,
                position: { lat: item.lat, lng: item.lng },
                content: createCard(item)
            });

            markers.push(marker);
        });
    }

    function createCard(item) {
        const div = document.createElement('div');
        div.innerHTML = `
            <div class="map-property-card">
                <img src="${item.image}" alt="${item.name}" />
                <div class="map-property-body">
                    <div class="map-property-name">${item.name}</div>
                    <div class="map-property-price">
                        ฿ ${Number(item.price).toLocaleString()}
                    </div>
                    <div class="map-property-meta">
                        ${item.bed} BD • ${item.bath} BA • ${item.size} m²
                    </div>
                </div>
            </div>
        `;
        return div.firstElementChild;
    }


    /* ---------------------------
       LIVEWIRE SAFE BOOTSTRAP
    ----------------------------*/
    document.addEventListener('livewire:init', () => {
        const wait = setInterval(() => {
            if (window.google?.maps) {
                clearInterval(wait);
                initMap();
            }
        }, 500);

        Livewire.on('updateMapListings', data => {
            renderMarkers(data);
        });
    });
</script>
@endpush
