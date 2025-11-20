<section class="bg-white dark:bg-surface-variant rounded-xl p-6 md:p-8 border border-outline">
    <h2 class="text-2xl font-bold text-on-surface mb-6">Nearby Locations</h2>
    <div class="space-y-4">
        @php
            $locations = $locations ?? [
                ['icon' => 'train', 'name' => 'BTS Asoke Station', 'distance' => '2 min walk'],
                ['icon' => 'hospital', 'name' => 'Bumrungrad Hospital', 'distance' => '5 min drive'],
                ['icon' => 'shopping', 'name' => 'Terminal 21 Mall', 'distance' => '3 min walk'],
                ['icon' => 'school', 'name' => 'International School', 'distance' => '10 min drive'],
            ];
        @endphp

        @foreach($locations as $location)
            <div class="flex items-center justify-between p-4 bg-surface-variant dark:bg-surface rounded-lg border border-outline">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-primary-100 dark:bg-primary-900 rounded-lg flex items-center justify-center">
                        @if($location['icon'] === 'train')
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                        @elseif($location['icon'] === 'hospital')
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        @elseif($location['icon'] === 'shopping')
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        @elseif($location['icon'] === 'school')
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            </svg>
                        @endif
                    </div>
                    <div>
                        <p class="font-semibold text-on-surface">{{ $location['name'] }}</p>
                        <p class="text-sm text-on-surface-variant">{{ $location['distance'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

