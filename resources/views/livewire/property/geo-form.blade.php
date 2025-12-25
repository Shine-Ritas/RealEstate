<div class="w-full">
    @if (session()->has('message'))
        <div class="mb-6 rounded-radius bg-success/10 border border-success/20 px-4 py-3 text-sm text-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit="save" class=" ">

        <div class=" space-y-4  ">
            {{-- Basic Information --}}
            <x-ui.accordian title="Add Nearby Location" open class="relative h-full" icon="location-crosshairs">

                {{-- grid all align center --}}
                <div class="grid gap-6 lg:grid-cols-5 items-end">
               
                    <div class="grid gap-2">

                        <x-ui.label for="locationElement" label="Location Element" required bold />
                        <x-searchable-select id="selectedLocationElement" name="selectedLocationElement" :options="$locationElements"
                            model="selectedLocationElement" />
                    </div>

                    <x-ui.input label="Full Text" name="distance"  wire:model.defer="fullText"
                    placeholder="e.g., *0000" required :error="$errors->first('fullText')" bold />

                    <x-ui.input label="Distance ( meters ) " name="distance"  wire:model.defer="distance"
                    placeholder="e.g., *0000" required :error="$errors->first('distance')" bold />

                    {{-- add button --}}
                    <x-ui.button type="button" variant="primary" class="btn btn-md w-12"  wire:loading.attr="disabled" wire:target="save">
                        <span wire:loading.remove wire:target="save">
                            <i class="fa-solid fa-plus"></i>
                        </span>
                        <span wire:loading wire:target="save">
                            <i class="fa-solid fa-spinner fa-spin"></i>
                        </span>
                    </x-ui.button>
                  
                </div>

            </x-ui.accordian>

            <x-ui.accordian title="Locations" open class="relative h-full" icon="location-dot">

                <x-slot:right>
                    @if(count($propertyLocationElements) > 0)
                        <span class="text-sm text-muted">{{ count($propertyLocationElements) }} Added</span>
                    @endif
                </x-slot:right>

                    <div class="flex  gap-2 gap-y-4 flex-wrap">
                        @foreach ($propertyLocationElements as $propertyLocationElement)
                           <div class="group relative border shadow-sm px-3 rounded-sm py-2">
                            <div class="absolute top-0 right-0 -translate-x-0/2 -translate-y-2/2 opacity-0 group-hover:opacity-100 transition-opacity z-10 ">
                                <button 
                                    type="button"
                                    wire:click="delete('{{ $propertyLocationElement->id }}')"
                                    onclick="return confirm('Are you sure you want to delete this location element?')"
                                    class="bg-red-600 text-white text-xs py-1 px-2 rounded-t-md hover:bg-red-700 font-medium shadow-lg cursor-pointer"
                                >
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>

                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2 text-sm">
                                    <i class="fa-solid fa-{{ $propertyLocationElement->locationElement->icon }}"></i>
                                    <span>{{ $propertyLocationElement->name }}</span>
                                </div>
                                <span class="ml-10 font-medium text-sm">{{ $propertyLocationElement->distance }}</span>
                            </div>
                           </div>
                        @endforeach
                </div>
            </x-ui.accordian>


            <x-ui.accordian title="Add Contact Information" open class="relative h-full" icon="address-book">
                <div class="grid gap-6 lg:grid-cols-5 items-end">
                    <x-ui.input label="Name" name="text"  wire:model.defer="text"
                    placeholder="Kelvin Or @line" required :error="$errors->first('text')" bold />

                    <x-ui.input label="Contact / Link" name="url"  wire:model.defer="url"
                    placeholder="+66****** Or https://example.com" required :error="$errors->first('url')" bold />

                    <div class="grid gap-2">
                        <x-ui.label for="selectedPropertyContactType" label="Contact Type" required bold />
                        <x-searchable-select id="selectedPropertyContactType" name="selectedPropertyContactType" :options="$propertyContactsTypes"
                            model="selectedPropertyContactType" />
                    </div>

                    <div class="grid gap-2">
                        <x-ui.label for="selectedPropertyContactType" label="Provider Type" required bold />
                        <x-searchable-select id="selectedProviderType" name="selectedProviderType" :options="$providerTypes"
                            model="selectedProviderType" />
                    </div>

                    <x-ui.button type="button" variant="primary" class="btn btn-md w-12"  wire:loading.attr="disabled" wire:click="saveContact">
                        <span wire:loading.remove wire:target="saveContact" class="cursor-pointer">
                            <i class="fa-solid fa-plus cursor-pointer"></i>
                        </span>
                        <span wire:loading wire:target="saveContact">
                            <i class="fa-solid fa-spinner fa-spin cursor-pointer"></i>
                        </span>
                    </x-ui.button>
                </div>
            </x-ui.accordian>

            <x-ui.accordian title="Contacts" open class="relative h-full" icon="location-dot">

                <x-slot:right>
                    @if(count($propertyContacts) > 0)
                        <span class="text-sm text-muted">{{ count($propertyContacts) }} Added</span>
                    @endif
                </x-slot:right>

                    <div class="flex  gap-2 gap-y-4 flex-wrap">
                        @foreach ($propertyContacts as $propertyContact)
                           <div class="group relative border shadow-sm px-3 rounded-sm py-2">
                            <div class="absolute top-0 right-0 -translate-x-0/2 -translate-y-2/2 opacity-0 group-hover:opacity-100 transition-opacity z-10 ">
                                <button 
                                    type="button"
                                    wire:click="delete('{{ $propertyContact->id }}')"
                                    onclick="return confirm('Are you sure you want to delete this location element?')"
                                    class="bg-red-600 text-white text-xs py-1 px-2 rounded-t-md hover:bg-red-700 font-medium shadow-lg cursor-pointer"
                                >
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>

                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-1 text-sm font-medium">
                                    <x-render-icon :icon="$propertyContact->icon" />
                                    <span>{{ $propertyContact->text }}</span>
                                </div>
                                <span class="ml-10 font-medium text-sm">{{ $propertyContact->url }}</span>
                            </div>
                           </div>
                        @endforeach
                </div>
            </x-ui.accordian>


        </div>
    </form>