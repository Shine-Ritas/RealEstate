<!DOCTYPE html>
<html data-theme="legend" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')

    <link rel="stylesheet" href="{{ asset('vendor/fancybox/dist/fancybox/fancybox.css') }}">
    <script src="{{ asset('vendor/fancybox/dist/fancybox/fancybox.umd.js') }}"></script>
</head>

<body class="bg-surface text-on-surface antialiased">

    <div class="relative min-h-screen bg-surface">


        {{ $slot }}

        <x-guest.footer />
    </div>
    @fluxScripts

    <!-- PWA Loading Script -->
    <script>
        // Show loading indicator on navigation
        document.addEventListener('DOMContentLoaded', () => {

            // Show loading on regular navigation
            document.addEventListener('click', (e) => {
                if (e.target.matches('a[href]') && !e.target.href.includes('#')) {
                    loadingIndicator.classList.add('active');
                }
            });
        });
    </script>

    <script>

    
        // initial draw
    </script>

    @livewireScripts
    @stack('scripts')


</body>

</html>