<section class="bg-surface py-16 md:py-16 flex flex-col gap-10">

    <x-guest.property-display-container title="near_mrt" :properties="$near_mrt" />

    <x-guest.property-display-container title="condos_near_school_and_unit" :properties="$near_school" />

    <x-guest.property-display-container title="luxury_estates" :properties="$luxury_estates" />

    <x-guest.property-display-container title="latest_projects" :properties="$latest_projects" />

</section>