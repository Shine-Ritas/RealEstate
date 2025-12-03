<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
    @stack('scripts')
</head>

<body class="bg-surface text-on-surface antialiased">

    <div class="min-h-screen bg-surface">

        <x-guest.header />

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

</body>

</html>