<section class="relative py-12 md:py-20 overflow-hidden bg-primary">
    <div class="container mx-auto px-4 md:px-6 lg:px-8">
        <div class="relative">
            <div id="map" class="h-[60vh] w-full rounded-xl"></div>

            <!-- Search Box -->
            <div class="absolute bottom-4 left-4 right-4 sm:right-auto sm:w-80 z-10">
                <div class="relative">
                    <input id="searchBox" type="text" placeholder="Search for a location..."
                        class="w-full bg-surface text-on-surface border border-outline rounded-radius px-4 py-3 pl-10 pr-10 shadow-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary" />
                    <i
                        class="fa fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant"></i>
                    <button id="clearSearchBtn" onclick="clearSearch()"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-on-surface cursor-pointer"
                        style="display: none;" type="button">
                        <i class="fa fa-solid fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Location button - only request geolocation on user click -->
            <button id="locateMeBtn" onclick="requestUserLocation()"
                class="absolute top-4 right-4 bg-primary text-on-primary px-4 py-2 rounded-radius shadow-lg hover:bg-primary-700 transition-colors z-10 flex items-center gap-2"
                title="Show my location">
                <i class="fa fa-solid fa-location-crosshairs"></i>
                <span class="hidden sm:inline">My Location</span>
            </button>
        </div>
    </div>
</section>

@push('scripts')
    <script>
        let map;
        let markers = [];
        let userMarker = null;
        let searchMarker = null;
        let autocomplete = null;
        let mapReady = false;
        let boundsUpdateTimeout = null;
        let lastBounds = null;
        let isInitialLoad = true;
        let currentMarkerScale = 1;


        // Livewire properties data (initial load)
        let listings = @js($propertiesData);

        /* ---------------------------
           MAP INITIALIZATION
        ----------------------------*/
        function initMap() {
            if (mapReady || !window.google) return;

            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 14,
                center: new google.maps.LatLng(13.7563, 100.5018), // Bangkok fallback
                mapId: "map" // MUST be a real Map ID in production
            });

            mapReady = true;

            // Add bounds change listener for dynamic updates
            map.addListener('bounds_changed', handleBoundsChange);
            map.addListener('dragend', handleBoundsChange);
            map.addListener('zoom_changed', handleBoundsChange);

            // Initialize search autocomplete
            initSearchAutocomplete();

            // Render markers first
            renderMarkers(listings);

            // Allow bounds updates after initial load
            setTimeout(() => {
                isInitialLoad = false;
            }, 1000);

            map.addListener('zoom_changed', updateMarkerScale);
            map.addListener('idle', updateMarkerScale);

        }

        function updateMarkerScale() {
            if (!map) return;

            const zoom = map.getZoom();

            if (zoom <= 10) currentMarkerScale = 0.55;
            else if (zoom === 11) currentMarkerScale = 0.65;
            else if (zoom === 12) currentMarkerScale = 0.75;
            else if (zoom === 13) currentMarkerScale = 0.85;
            else if (zoom === 14) currentMarkerScale = 0.95;
            else currentMarkerScale = 1.05;

            markers.forEach(marker => {
                applyScale(marker);
            });
        }




        /* ---------------------------
           MAP BOUNDS HANDLING
        ----------------------------*/
        function handleBoundsChange() {
            // Skip bounds updates during initial load
            if (isInitialLoad) return;

            // Debounce to avoid too many requests
            if (boundsUpdateTimeout) {
                clearTimeout(boundsUpdateTimeout);
            }

            boundsUpdateTimeout = setTimeout(() => {
                if (!mapReady || !map) return;

                const bounds = map.getBounds();
                if (!bounds) return;

                const ne = bounds.getNorthEast();
                const sw = bounds.getSouthWest();

                // Check if bounds actually changed significantly
                const currentBounds = {
                    north: ne.lat(),
                    south: sw.lat(),
                    east: ne.lng(),
                    west: sw.lng()
                };

                if (lastBounds &&
                    Math.abs(lastBounds.north - currentBounds.north) < 0.01 &&
                    Math.abs(lastBounds.south - currentBounds.south) < 0.01 &&
                    Math.abs(lastBounds.east - currentBounds.east) < 0.01 &&
                    Math.abs(lastBounds.west - currentBounds.west) < 0.01) {
                    return; // Bounds haven't changed significantly
                }

                lastBounds = currentBounds;

                // Use AJAX to fetch properties by bounds
                fetchPropertiesByBounds(
                    currentBounds.north,
                    currentBounds.south,
                    currentBounds.east,
                    currentBounds.west
                );
            }, 500); // 500ms debounce
        }

        /* ---------------------------
           AJAX PROPERTY FETCHING
        ----------------------------*/
        async function fetchPropertiesByBounds(north, south, east, west) {
            try {
                const url = new URL('{{ route("api.properties.map-bounds") }}', window.location.origin);
                url.searchParams.append('north', north);
                url.searchParams.append('south', south);
                url.searchParams.append('east', east);
                url.searchParams.append('west', west);

                const response = await fetch(url, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                });

                if (!response.ok) {
                    throw new Error('Failed to fetch properties');
                }

                const data = await response.json();

                if (Array.isArray(data)) {
                    // Update the listings variable with new data
                    listings.length = 0;
                    listings.push(...data);
                    renderMarkers(data);
                }
            } catch (error) {
                console.error('Error fetching properties:', error);
            }
        }





        /* ---------------------------
           USER LOCATION
        ----------------------------*/
        // Request user location - must be called from user gesture
        function requestUserLocation() {
            if (!navigator.geolocation) {
                alert('Geolocation is not supported by this browser.');
                return;
            }

            const btn = document.getElementById('locateMeBtn');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fa fa-solid fa-spinner fa-spin"></i> <span class="hidden sm:inline">Locating...</span>';
            }

            navigator.geolocation.getCurrentPosition(
                position => {
                    if (!mapReady || !map) {
                        if (btn) {
                            btn.disabled = false;
                            btn.innerHTML = '<i class="fa fa-solid fa-location-crosshairs"></i> <span class="hidden sm:inline">My Location</span>';
                        }
                        return;
                    }

                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    // Create proper LatLng instance
                    const userLatLng = new google.maps.LatLng(lat, lng);

                    // Remove existing user marker if any
                    if (userMarker) {
                        userMarker.map = null;
                    }

                    // Create user marker
                    const userDot = createUserDot();
                    userMarker = new google.maps.marker.AdvancedMarkerElement({
                        map: map,
                        position: userLatLng,
                        content: userDot,
                        zIndex: 1000 // Ensure it's on top
                    });

                    // Adjust map to show both user location and property markers
                    adjustMapBounds(userLatLng);

                    // Reset button
                    if (btn) {
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fa fa-solid fa-location-crosshairs"></i> <span class="hidden sm:inline">My Location</span>';
                    }
                },
                (error) => {
                    // Handle errors with more detail
                    let errorMsg = 'Unable to get your location.';
                    switch (error.code) {
                        case error.PERMISSION_DENIED:
                            errorMsg = 'Location access denied. Please enable location permissions.';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            errorMsg = 'Location information unavailable.';
                            break;
                        case error.TIMEOUT:
                            errorMsg = 'Location request timed out.';
                            break;
                    }
                    alert(errorMsg);

                    // Reset button
                    const btn = document.getElementById('locateMeBtn');
                    if (btn) {
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fa fa-solid fa-location-crosshairs"></i> <span class="hidden sm:inline">My Location</span>';
                    }
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 300000 // 5 minutes
                }
            );
        }

        function createUserDot() {
            const div = document.createElement('div');
            div.style.cssText = `
                    width: 20px;
                    height: 20px;
                    background: #2563eb;
                    border: 4px solid white;
                    border-radius: 50%;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.3), 0 0 0 4px rgba(37,99,235,0.2);
                    cursor: pointer;
                `;
            return div;
        }

        function adjustMapBounds(userLatLng) {
            if (!map || !mapReady) return;

            const bounds = new google.maps.LatLngBounds();

            // Add user location to bounds
            bounds.extend(userLatLng);

            // Add all property markers to bounds
            if (listings && listings.length > 0) {
                listings.forEach(item => {
                    const lat = parseFloat(item.lat);
                    const lng = parseFloat(item.lng);
                    if (!isNaN(lat) && !isNaN(lng)) {
                        bounds.extend(new google.maps.LatLng(lat, lng));
                    }
                });
            }


            // Fit map to show both user and properties with padding
            if (listings && listings.length > 0 && !userLatLng) {
                map.fitBounds(bounds, {
                    padding: { top: 10, right: 10, bottom: 10, left: 10 }
                });
            } else {
                // If no properties, just center on user
                map.setCenter(userLatLng);
                map.setZoom(15);
            }
        }

        function applyScale(marker) {
            const el = marker.content;
            if (!el) return;

            el.style.transform = `scale(${currentMarkerScale})`;
            el.style.opacity = map.getZoom() < 12 ? '0.85' : '1';
        }



        /* ---------------------------
           PROPERTY MARKERS
        ----------------------------*/
        function clearMarkers() {
            markers.forEach(m => m.map = null);
            markers = [];
        }

        function renderMarkers(items) {
            if (!mapReady || !items || items.length === 0) return;

            clearMarkers();

            items.forEach(item => {
                // Ensure lat and lng are numbers
                const lat = parseFloat(item.lat);
                const lng = parseFloat(item.lng);

                // Skip if coordinates are invalid
                if (isNaN(lat) || isNaN(lng)) {
                    console.warn('Invalid coordinates for property:', item.id, item);
                    return;
                }

                // Create proper LatLng instance
                const position = new google.maps.LatLng(lat, lng);

                const marker = new google.maps.marker.AdvancedMarkerElement({
                    map,
                    position: position,
                    content: createCard(item)
                });

                applyScale(marker);

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
           SEARCH FUNCTIONALITY
        ----------------------------*/
        function initSearchAutocomplete() {
            if (!window.google?.maps?.places) {
                console.warn('Places library not loaded');
                return;
            }

            const searchInput = document.getElementById('searchBox');
            if (!searchInput) return;

            // Create autocomplete
            autocomplete = new google.maps.places.Autocomplete(searchInput, {
                types: ['geocode', 'establishment'],
                componentRestrictions: { country: 'th' }, // Restrict to Thailand
                fields: ['geometry', 'name', 'formatted_address']
            });

            // Bias autocomplete results towards map viewport
            autocomplete.bindTo('bounds', map);

            // Show/hide clear button based on input
            searchInput.addEventListener('input', (e) => {
                const clearBtn = document.getElementById('clearSearchBtn');
                if (clearBtn) {
                    clearBtn.style.display = e.target.value ? 'block' : 'none';
                }
            });

            // Handle place selection
            autocomplete.addListener('place_changed', () => {
                const place = autocomplete.getPlace();

                if (!place.geometry || !place.geometry.location) {
                    console.warn('No details available for selected place');
                    return;
                }

                // Show clear button
                const clearBtn = document.getElementById('clearSearchBtn');
                if (clearBtn) {
                    clearBtn.style.display = 'block';
                }

                // Center map on selected place
                const location = place.geometry.location;
                map.setCenter(location);
                map.setZoom(15);

                // Remove existing search marker
                if (searchMarker) {
                    searchMarker.map = null;
                }

                // Add marker for searched location
                const markerContent = createSearchMarkerContent(place.name || place.formatted_address);
                searchMarker = new google.maps.marker.AdvancedMarkerElement({
                    map: map,
                    position: location,
                    content: markerContent,
                    zIndex: 999
                });

                // Temporarily disable bounds updates to prevent immediate property refresh
                const wasInitialLoad = isInitialLoad;
                isInitialLoad = true;

                // Fetch properties for new location after a short delay
                setTimeout(() => {
                    const bounds = map.getBounds();
                    if (bounds) {
                        const ne = bounds.getNorthEast();
                        const sw = bounds.getSouthWest();
                        fetchPropertiesByBounds(
                            ne.lat(),
                            sw.lat(),
                            ne.lng(),
                            sw.lng()
                        );
                    }
                    isInitialLoad = wasInitialLoad;
                }, 500);
            });
        }

        function createSearchMarkerContent(name) {
            const div = document.createElement('div');
            div.style.cssText = `
                    background: #10b981;
                    color: white;
                    padding: 8px 12px;
                    border-radius: 8px;
                    font-size: 14px;
                    font-weight: 600;
                    white-space: nowrap;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.3);
                    border: 2px solid white;
                    bottom:0px;
                `;
            div.textContent = name;
            return div;
        }

        function clearSearch() {
            const searchInput = document.getElementById('searchBox');
            const clearBtn = document.getElementById('clearSearchBtn');

            if (searchInput) {
                searchInput.value = '';
            }

            if (clearBtn) {
                clearBtn.style.display = 'none';
            }

            // Remove search marker
            if (searchMarker) {
                searchMarker.map = null;
                searchMarker = null;
            }
        }

        // Make clearSearch available globally
        window.clearSearch = clearSearch;

        /* ---------------------------
           MAP INITIALIZATION
        ----------------------------*/
        // Use proper Google Maps loading pattern
        function initializeMap() {
            initMap();
        }

        // Make initMap available globally for callback
        window.initPropertyMap = initializeMap;

        // Initialize map when Google Maps is loaded
        function waitForGoogleMaps() {
            if (window.google?.maps) {
                initMap();
            } else {
                setTimeout(waitForGoogleMaps, 100);
            }
        }

        // Start initialization
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', waitForGoogleMaps);
        } else {
            waitForGoogleMaps();
        }
    </script>
@endpush