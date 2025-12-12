
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-secondary-background dark:bg-zinc-800">

        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <!-- Header with Logo and Title -->
            <a href="{{ route('dashboard') }}" class="me-5 mb-6 flex items-center gap-3 rtl:space-x-reverse" wire:navigate>
                <div class="flex aspect-square size-10 items-center justify-center rounded-md bg-primary text-on-primary">
                    <flux:icon.home class="size-6" />
                </div>
                <div class="grid flex-1 text-start">
                    <span class="truncate font-barlow-condensed text-lg font-semibold text-on-surface">RealEstate</span>
                    <span class="truncate text-xs text-on-surface-variant">Admin Panel</span>
                </div>
            </a>

            <!-- Navigation Menu -->
            <flux:navlist variant="outline" class="sidebar-nav">
                @foreach (sidebar() as $sidebar)
                    @if (isset($sidebar['permission']) && ($sidebar['permission'] == 'public' || auth()->user()->hasPermissionTo($sidebar['permission'])))
                        @if(isset($sidebar['children']))
                            @php
                                $isExpanded = false;
                                foreach($sidebar['children'] as $child) {
                                    $routeMatch = isset($child['route_name']) 
                                        ? request()->routeIs($child['route_name']) 
                                        : request()->routeIs($child['route']);
                                    if($routeMatch) {
                                        $isExpanded = true;
                                        break;
                                    }
                                }
                            @endphp
                            <flux:navlist.group 
                                :heading="__($sidebar['title'])" 
                                :icon="$sidebar['icon']"
                                expandable
                                :expanded="$isExpanded"
                                class="grid nav-group cursor-pointer mb-1"
                            >
                                <div class="flex flex-col gap-1 mt-2">
                                    @foreach($sidebar['children'] as $child)
                                        @if(isset($child['permission']) && ($child['permission'] == 'public' || auth()->user()->hasPermissionTo($child['permission'])))
                                            <flux:navlist.item 
                                                :icon="$child['icon']" 
                                                :href="$child['route']" 
                                                :current="isset($child['route_name']) ? request()->routeIs($child['route_name']) : request()->routeIs($child['route'])" 
                                                wire:navigate
                                                class="rounded-lg"
                                            >
                                                {{ __($child['title']) }}
                                            </flux:navlist.item>
                                        @endif
                                    @endforeach
                                </div>
                            </flux:navlist.group>
                        @else
                            <flux:navlist.item 
                                :icon="$sidebar['icon']" 
                                :href="$sidebar['route']" 
                                :current="isset($sidebar['route_name']) ? request()->routeIs($sidebar['route_name']) : request()->routeIs($sidebar['route'])" 
                                wire:navigate
                                class="rounded-lg"
                            >
                                {{ __($sidebar['title']) }}
                            </flux:navlist.item>
                        @endif
                    @endif
                @endforeach
            </flux:navlist>

            <flux:spacer />

            <!-- Footer User Section -->
            <div class="border-t border-outline pt-4">
                <flux:dropdown class="w-full" position="top" align="start">
                    <button class="flex w-full items-center gap-3 rounded-lg p-2 text-start transition-colors hover:bg-surface-variant dark:hover:bg-zinc-800" data-test="sidebar-user-button">
                        <span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-lg">
                            <span class="flex h-full w-full items-center justify-center rounded-lg bg-primary text-on-primary">
                                {{ auth()->user()->initials() }}
                            </span>
                        </span>
                        <div class="grid flex-1 text-start text-sm leading-tight">
                            <span class="truncate font-semibold text-on-surface">{{ auth()->user()->name ?? 'Admin User' }}</span>
                            <span class="truncate text-xs text-on-surface-variant">{{ auth()->user()->email ?? 'admin@realestate.com' }}</span>
                        </div>
                        <flux:icon.chevron-down class="size-4 text-on-surface-variant" />
                    </button>

                    <flux:menu class="w-[220px]">
                        <flux:menu.radio.group>
                            <div class="p-0 text-sm font-normal">
                                <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                    <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                        <span class="flex h-full w-full items-center justify-center rounded-lg bg-primary text-on-primary">
                                            {{ auth()->user()->initials() }}
                                        </span>
                                    </span>

                                    <div class="grid flex-1 text-start text-sm leading-tight">
                                        <span class="truncate font-semibold text-on-surface">{{ auth()->user()->name ?? 'Admin User' }}</span>
                                        <span class="truncate text-xs text-on-surface-variant">{{ auth()->user()->email ?? 'admin@realestate.com' }}</span>
                                    </div>
                                </div>
                            </div>
                        </flux:menu.radio.group>

                        <flux:menu.separator />

                        <flux:menu.radio.group>
                            <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                        </flux:menu.radio.group>

                        <flux:menu.separator />

                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full" data-test="logout-button">
                                {{ __('Log Out') }}
                            </flux:menu.item>
                        </form>
                    </flux:menu>
                </flux:dropdown>
            </div>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full" data-test="logout-button">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
