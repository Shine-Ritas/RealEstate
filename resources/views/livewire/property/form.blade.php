<div class="w-full">
    @if (session()->has('message'))
        <div class="mb-6 rounded-radius bg-success/10 border border-success/20 px-4 py-3 text-sm text-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit="save" class=" ">

        <div class=" space-y-4  ">
            {{-- Basic Information --}}
            <x-ui.accordian title="Basic Information" open class="relative h-full" icon="database">

                <div class="grid gap-6 lg:grid-cols-3">
                    <x-ui.input label="Project Name" name="name" wire:model.live="name"
                        placeholder="e.g., Luxury Condominium" required :error="$errors->first('name')" bold />

                    <div class="grid gap-2">

                        <x-ui.label for="propertyType" label="Property Type" required bold />
                        <x-searchable-select id="propertyType" name="propertyType" :options="$propertyTypes"
                            model="propertyType" />
                    </div>

                    <div class="grid gap-2">

                        <x-ui.label for="listingType" label="Listing Type" required bold />

                        <x-searchable-select id="listingType" name="listingType" :options="$listingTypes"
                            model="listingType" />
                    </div>


                    <x-ui.input label="Sale Price ( {{ currency() }} ) " name="current_price" type="number" wire:model.live="name"
                    placeholder="e.g., *0000" required :error="$errors->first('name')" bold />

                    <x-ui.input label="Current Price ( {{ currency() }} ) " name="current_price" type="number" wire:model.live="name"
                    placeholder="e.g., *0000" required :error="$errors->first('name')" bold />

                    <x-ui.input label="Rent Price ( {{ currency() }} ) " name="current_price" type="number" wire:model.live="name"
                    placeholder="e.g., *0000" required :error="$errors->first('name')" bold />

                </div>

                <x-ui.label for="listingType" label="Description" required  bold/>
                    @livewire('livewire-quill', [
                        'quillId' => 'customQuillId',
                        'data' => $description,
                        'placeholder' => 'Type something...',
                        'classes' => 'bg-white', // optional classes that can be added to the editor, that are added for this instance only
                        'toolbar' => [
                            [
                                [
                                    'header' => [1, 2, 3, 4, 5, 6, false],
                                ],
                            ],
                            ['bold', 'italic', 'underline'],
                            [
                                [
                                    'list' => 'ordered',
                                ],
                                [
                                    'list' => 'bullet',
                                ],
                            ],
                            ['link'],
                            ['image'],
                        ],
                        'mergeToolbar' => true, // optional, if you want to merge the toolbar with the default toolbar configuration
                    ])
            </x-ui.accordian>



            <x-ui.accordian title="Geolocation Information" open icon='globe'>

                <div class="grid gap-6 lg:grid-cols-3">

                    <div class="grid gap-2">

                        <x-ui.label for="listingType" label="Province" required bold />

                        <x-searchable-select id="province" name="province" :options="$provinces"
                        placeholder="Choose Province"
                            model="selectedProvince" />
                    </div>

                    <div class="grid gap-2" >
                        <x-ui.label for="district" label="District" required bold />
                        <x-searchable-select id="district" name="district" :options="$districts"
                        placeholder="Choose District" :disabled="!$selectedProvince"
                        event="district-options-updated"
                            model="selectedDistrict" />
                    </div>

                    <div class="grid gap-2">
                        <x-ui.label for="sub_district" label="Sub District" required bold />
                        <x-searchable-select id="sub_district" name="sub_district" :options="$subDistricts"
                        placeholder="Choose Sub District" :disabled="!$selectedDistrict"
                        event="sub-district-options-updated"
                            model="selectedSubDistrict" />
                    </div>

                    <x-ui.input label="Postal Code" name="zipcode" type="number" wire:model.live="zipcode"
                    placeholder="e.g., 13.7563" required :error="$errors->first('zipcode')" bold />

                    <x-ui.input label="Latitude" name="latitude" type="number" wire:model.live="latitude"
                    placeholder="e.g., 13.7563" required :error="$errors->first('latitude')" bold />

                    <x-ui.input label="Longitude" name="longitude" type="number" wire:model.live="longitude"
                    placeholder="e.g., 100.5018" required :error="$errors->first('longitude')" bold />

                </div>
            </x-ui.accordian>
       

            <x-ui.accordian title="Facility Information" open icon='dumbbell'>
                <x-slot:right>
                    <span x-data="{ count: @entangle('selectedFacilities').live }"
                        x-text="count.length ? `${count.length} selected` : ''" class="text-sm text-muted"></span>
                </x-slot:right>

                <div x-data="{ selected: @entangle('selectedFacilities').live }"
                    class="flex flex-wrap gap-3 items-center">
                    @foreach($facilities as $facility)
                        <div wire:key="facility-{{ $facility->id }}" @click="
                                    selected.includes({{ $facility->id }})
                                        ? selected = selected.filter(i => i !== {{ $facility->id }})
                                        : selected.push({{ $facility->id }})
                                " class="flex items-center gap-2 badge cursor-pointer"
                            :class="selected.includes({{ $facility->id }}) ? 'badge-primary' : 'badge-outline'">
                            <x-ui.icon-preview :name="$facility->icon" size="size-8" />
                            <span>{{ $facility->name }}</span>
                        </div>
                    @endforeach
                </div>
            </x-ui.accordian>



        </div>


        <div
            class="bg-surface rounded-radius border border-outline shadow-sm px-8 py-5 flex items-center justify-between mt-3">
            <a href="{{ route('projects.index') }}" wire:navigate class="btn btn-danger">
                Cancel
            </a>

            <x-ui.button type="submit" variant="primary">
                <span wire:loading.remove wire:target="save">
                    {{ $projectId ? 'Update' : 'Create' }} Project
                </span>
                <span wire:loading wire:target="save">
                    {{ $projectId ? 'Updating...' : 'Creating...' }}
                </span>
            </x-ui.button>
        </div>
    </form>
</div>