<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  >
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen antialiased">
        <div class="flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10"
        style="background-image: url('{{ asset('assets/bg/guest-bg.jpg') }}'); background-size: cover; background-position: center;"
        {{-- add alittle dark overlay --}}
        >
            <div class="flex w-full max-w-sm flex-col gap-2">
               
                <div class="flex flex-col gap-6">
                    {{ $slot }}
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
