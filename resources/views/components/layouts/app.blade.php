<x-layouts.app.sidebar :title="$title ?? null">


    <x-ui.page-header :header="$header ?? 'Welcome Back !'" :subtitle="$subtitle ?? 'Overview of your real estate business'" />

    <flux:main class="px-6 !py-3 max-h-screen overflow-y-scroll">
        {{ $slot }}
    </flux:main>

    <x-ui.notification-stack :sound="true" :duration="6000" />

</x-layouts.app.sidebar>