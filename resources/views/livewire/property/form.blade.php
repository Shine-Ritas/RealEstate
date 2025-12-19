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


                    <x-ui.input label="Sale Price ( {{ currency() }} ) " name="current_price" type="number" wire:model.defer="salePrice"
                    placeholder="e.g., *0000" required :error="$errors->first('salePrice')" bold />

                    <x-ui.input label="Current Price ( {{ currency() }} ) " name="current_price" type="number" wire:model.defer="currentPrice"
                    placeholder="e.g., *0000" required :error="$errors->first('currentPrice')" bold />

                    <x-ui.input label="Rent Price ( {{ currency() }} ) " name="current_price" type="number" wire:model.defer="rentPrice"
                        placeholder="e.g., *0000" required :error="$errors->first('rentPrice')" bold />

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

                        <x-ui.label for="province" label="Province" required bold />

                        <x-searchable-select id="selectedProvince" name="selectedProvince" :options="$provinces"
                        placeholder="Choose Province"
                            model="selectedProvince" />
                    </div>

                    <div class="grid gap-2" >
                        <x-ui.label for="selectedDistrict" label="District" required bold />
                        <x-searchable-select id="selectedDistrict" name="selectedDistrict" :options="$districts"
                        placeholder="Choose District" :disabled="!$selectedProvince"
                        event="district-options-updated"
                            model="selectedDistrict" />
                    </div>

                    <div class="grid gap-2">
                        <x-ui.label for="selectedSubDistrict" label="Sub District" required bold />
                        <x-searchable-select id="selectedSubDistrict" name="selectedSubDistrict" :options="$subDistricts"
                        placeholder="Choose Sub District" :disabled="!$selectedDistrict"
                        event="sub-district-options-updated"
                            model="selectedSubDistrict" />
                    </div>

                    <x-ui.input label="Postal Code" name="zipcode" type="number" wire:model.defer="zipcode"
                    placeholder="e.g., 13.7563" required :error="$errors->first('zipcode')" bold />

                    <x-ui.input label="Latitude" name="latitude" type="number" wire:model.defer="latitude"
                    placeholder="e.g., 13.7563" required :error="$errors->first('latitude')" bold />

                    <x-ui.input label="Longitude" name="longitude" type="number" wire:model.defer="longitude"
                    placeholder="e.g., 100.5018" required :error="$errors->first('longitude')" bold />

                </div>
            </x-ui.accordian>

            <x-ui.accordian title="Room Details" open icon='bed'>

              <div class="grid gap-6 lg:grid-cols-3">

                <x-ui.input label="Floor" name="floor" type="number" wire:model.defer="floor"
                placeholder="e.g., 1-1000" required :error="$errors->first('floor')" bold />

                <x-ui.input label="Unit Number" name="unitNumber" wire:model.defer="unitNumber"
                placeholder="e.g., total units" required :error="$errors->first('unitNumber')" bold />

                <x-ui.input label="Bed Room" name="bedrooms" type="number" wire:model.defer="bedrooms"
                placeholder="e.g., 1-50" required :error="$errors->first('bedrooms')" bold />

                <x-ui.input label="BathRooms" name="bathrooms" type="number" wire:model.defer="bathrooms"
                placeholder="e.g., 1-50" required :error="$errors->first('bathrooms')" bold />
             
                <x-ui.input label="Size ( Sqm )" name="sizeSqm" type="number" wire:model.defer="sizeSqm"
                placeholder="e.g., ***" required :error="$errors->first('sizeSqm')" bold />
                
                <x-ui.input label="Land Size ( Sqm )" name="landSizeSqm" type="number" wire:model.defer="landSizeSqm"
                placeholder="e.g., ***" required :error="$errors->first('landSizeSqm')" bold />

                <div class="grid gap-2">
                    <x-ui.label for="ownership" label="Ownership Type" required bold />
                    <x-searchable-select id="ownership" name="ownership" :options="$ownershipTypes"
                        model="ownership" />
                </div>

                <div class="grid gap-2">
                    <x-ui.label for="propertyStatus" label="Property Status" required bold />
                    <x-searchable-select id="propertyStatus" name="propertyStatus" :options="$propertyStatusTypes"
                        model="propertyStatus" />
                </div>

                <x-ui.input label="Year Built" name="yearBuilt" type="number" wire:model.defer="yearBuilt"
                placeholder="e.g., ****" :error="$errors->first('yearBuilt')" bold />

                <x-ui.input label="Number Of Room/House" name="number" type="text" wire:model.defer="number"
                placeholder="e.g., **/**" :error="$errors->first('number')" bold />

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
                            :class="selected.includes({{ $facility->id }}) ? 'badge-primary hover:bg-primary/60' : 'badge-outline hover:bg-primary/30'">
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