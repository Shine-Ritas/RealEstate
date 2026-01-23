<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

<script src="https://kit.fontawesome.com/f39d469662.js" crossorigin="anonymous"></script>


<script>
    // Google Maps Loader - proper loading pattern
    window.initGoogleMaps = function() {
        // Maps API is loaded, our code will check for window.google.maps
        if (window.google && window.google.maps) {
            // Trigger custom event for components that need it
            window.dispatchEvent(new Event('googlemapsloaded'));
        }
    };
</script>

@php
    $googleMapLang = match (app()->getLocale()) {
        'zh' => 'zh-CN',
        'zh_TW' => 'zh-TW',
        'th' => 'th',
        'my' => 'my',
        default => 'en',
    };
@endphp

<script async defer 
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAwfFhF3hutd5l1lIAdnoYVrfbPMfxH5fM&callback=initGoogleMaps&libraries=maps,marker,places&v=beta&language={{ $googleMapLang }}">
</script>
@vite(['resources/css/app.css', 'resources/js/app.js'])



@fluxAppearance
