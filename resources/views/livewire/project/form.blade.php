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

                <div class="grid gap-6 lg:grid-cols-2">
                    <x-ui.input label="Project Name" name="name" wire:model.live="name"
                        placeholder="e.g., Luxury Condominium" required :error="$errors->first('name')" />

                    <div class="grid gap-2 lg:max-w-full">
                        <label for="developerId" class="text-sm font-medium text-on-surface">
                            Developer
                        </label>
                        <flux:select id="developerId" name="developerId" wire:model.defer="developerId" class="w-full">
                            <option value="">Select a developer (optional)</option>
                            @foreach($developers as $developer)
                                <option value="{{ $developer->ulid }}">{{ $developer->name }}</option>
                            @endforeach
                        </flux:select>
                        @if($errors->first('developerId'))
                            <p class="text-sm text-danger">{{ $errors->first('developerId') }}</p>
                        @endif
                    </div>
                </div>

                <x-ui.textarea label="Description" name="description" wire:model.defer="description"
                    placeholder="Enter project description..." rows="4" :error="$errors->first('description')" />
            </x-ui.accordian>

            {{-- Location Information --}}
            <x-ui.accordian title="Location Information" open>

                <div class="grid gap-6 lg:grid-cols-2">
                    <div class="grid gap-2">
                        <label for="provinceId" class="text-sm font-medium text-on-surface">
                            Province <span class="text-danger">*</span>
                        </label>
                        <flux:select id="provinceId" name="provinceId" wire:model.live="provinceId" required
                            class="w-full">
                            <option value="">Select a province</option>
                            @foreach($provinces as $province)
                                <option value="{{ $province->id }}">{{ $province->p_name }}</option>
                            @endforeach
                        </flux:select>
                        @if($errors->first('provinceId'))
                            <p class="text-sm text-danger">{{ $errors->first('provinceId') }}</p>
                        @endif
                    </div>

                    <div class="grid gap-2">
                        <label for="districtId" class="text-sm font-medium text-on-surface">
                            District <span class="text-danger">*</span>
                        </label>
                        @if($provinceId)
                            <flux:select id="districtId" name="districtId" wire:model.defer="districtId" required
                                class="w-full">
                                <option value="">Select a district</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}">{{ $district->d_name }}</option>
                                @endforeach
                            </flux:select>
                        @else
                            <flux:select id="districtId" name="districtId" wire:model.defer="districtId" required
                                class="w-full" disabled>
                                <option value="">Select province first</option>
                            </flux:select>
                        @endif
                        @if($errors->first('districtId'))
                            <p class="text-sm text-danger">{{ $errors->first('districtId') }}</p>
                        @endif
                    </div>
                </div>

                <x-ui.input label="Address" name="address" wire:model.defer="address"
                    placeholder="e.g., 123 Main Street" :error="$errors->first('address')" />

                <div class="grid gap-6 lg:grid-cols-2">
                    <x-ui.input label="Latitude" name="latitude" type="number" step="0.00000001"
                        wire:model.defer="latitude" placeholder="e.g., 13.7563" :error="$errors->first('latitude')" />

                    <x-ui.input label="Longitude" name="longitude" type="number" step="0.00000001"
                        wire:model.defer="longitude" placeholder="e.g., 100.5018"
                        :error="$errors->first('longitude')" />
                </div>
            </x-ui.accordian>

            {{-- Project Details --}}

            <x-ui.accordian title="Detail Information" open>

                <div class="grid gap-6 lg:grid-cols-4">
                    <x-ui.input label="Total Floors" name="totalFloors" type="number" wire:model.defer="totalFloors"
                        placeholder="e.g., 30" min="1" :error="$errors->first('totalFloors')" />

                    <x-ui.input label="Total Units" name="totalUnits" type="number" wire:model.defer="totalUnits"
                        placeholder="e.g., 500" min="1" :error="$errors->first('totalUnits')" />

                    <x-ui.input label="Year Completed" name="yearCompleted" type="number"
                        wire:model.defer="yearCompleted" placeholder="e.g., 2024" min="1900" :max="date('Y') + 10"
                        :error="$errors->first('yearCompleted')" />

                    <div class="grid gap-2">
                        <label for="status" class="text-sm font-medium text-on-surface">
                            Status <span class="text-danger">*</span>
                        </label>
                        <flux:select id="status" name="status" wire:model.defer="status" required class="w-full">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </flux:select>
                        @if($errors->first('status'))
                            <p class="text-sm text-danger">{{ $errors->first('status') }}</p>
                        @endif
                    </div>
                </div>
            </x-ui.accordian>

            <x-ui.accordian title="Facility Information" open>
                <x-slot:right>
                        <span
                        x-data="{ count: @entangle('selectedFacilities').live }"
                        x-text="count.length ? `${count.length} selected` : ''"
                        class="text-sm text-muted"
                    ></span>
                </x-slot:right>
            
                <div
                    x-data="{ selected: @entangle('selectedFacilities').live }"
                    class="flex flex-wrap gap-3 items-center"
                >
                    @foreach($facilities as $facility)
                        <div
                            wire:key="facility-{{ $facility->id }}"
                            @click="
                                selected.includes({{ $facility->id }})
                                    ? selected = selected.filter(i => i !== {{ $facility->id }})
                                    : selected.push({{ $facility->id }})
                            "
                            class="flex items-center gap-2 badge cursor-pointer"
                            :class="selected.includes({{ $facility->id }}) ? 'badge-primary' : 'badge-outline'"
                        >
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