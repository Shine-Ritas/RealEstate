<div class="w-full">
    @if (session()->has('message'))
        <div class="mb-6 rounded-radius bg-success/10 border border-success/20 px-4 py-3 text-sm text-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit="save" class=" ">

        <div class=" space-y-4  ">
            {{-- Basic Information --}}
            <x-ui.accordian title="Basic Information" open>

                <div class="grid gap-6 lg:grid-cols-3">
                    <x-ui.input label="Project Name" name="name" wire:model.live="name"
                        placeholder="e.g., Luxury Condominium" required :error="$errors->first('name')" />


                    <div class="grid gap-2">
                        <label for="propertyType" class="text-sm font-medium text-on-surface">
                            {{ __('Property Type') }} <span class="text-danger">*</span>
                        </label>
                        <x-searchable-select id="propertyType" name="propertyType" :options="$propertyTypes" model="propertyType" />
                    </div>

                    <div class="grid gap-2">
                        <label for="listingType" class="text-sm font-medium text-on-surface">
                            {{ __('Listing Type') }} <span class="text-danger">*</span>
                        </label>
                        <x-searchable-select id="listingType" name="listingType" :options="$listingTypes" model="listingType" />
                    </div>

                </div>



                <x-ui.textarea label="Description" name="description" wire:model.defer="description"
                    placeholder="Enter project description..." rows="4" :error="$errors->first('description')" />
            </x-ui.accordian>

       

            <x-ui.accordian title="Facility Information" open>
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