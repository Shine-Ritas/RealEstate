<div class="w-full">
    @if (session()->has('message'))
        <div class="mb-6 rounded-radius bg-success/10 border border-success/20 px-4 py-3 text-sm text-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit="save" class="bg-surface rounded-radius border border-outline shadow-sm">
        <div class="border-b border-outline px-8 py-5">
            <h2 class="text-xl font-semibold text-on-surface">
                {{ $projectId ? 'Edit Project' : 'Create New Project' }}
            </h2>
        </div>

        <div class="px-8 py-8 space-y-8">
            {{-- Basic Information --}}
            <div class="space-y-6">
                <h3 class="text-lg font-semibold text-on-surface border-b border-outline pb-3">
                    Basic Information
                </h3>

                <div class="grid gap-6 lg:grid-cols-2">
                    <x-ui.input
                        label="Project Name"
                        name="name"
                        wire:model.live="name"
                        placeholder="e.g., Luxury Condominium"
                        required
                        :error="$errors->first('name')"
                    />

                    <div class="grid gap-2">
                        <label for="slug" class="text-sm font-medium text-on-surface">
                            Slug <span class="text-danger">*</span>
                            <span class="text-xs text-on-surface-variant font-normal">(Auto-generated from name)</span>
                        </label>
                        <flux:input
                            id="slug"
                            name="slug"
                            wire:model="slug"
                            placeholder="e.g., luxury-condominium"
                            required
                            class="w-full"
                        />
                        @if($errors->first('slug'))
                            <p class="text-sm text-danger">{{ $errors->first('slug') }}</p>
                        @endif
                    </div>
                </div>

                <x-ui.textarea
                    label="Description"
                    name="description"
                    wire:model.defer="description"
                    placeholder="Enter project description..."
                    rows="4"
                    :error="$errors->first('description')"
                />

                <div class="grid gap-2 lg:max-w-md">
                    <label for="developerId" class="text-sm font-medium text-on-surface">
                        Developer
                    </label>
                    <flux:select
                        id="developerId"
                        name="developerId"
                        wire:model.defer="developerId"
                        class="w-full"
                    >
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

            {{-- Location Information --}}
            <div class="space-y-6">
                <h3 class="text-lg font-semibold text-on-surface border-b border-outline pb-3">
                    Location Information
                </h3>

                <div class="grid gap-6 lg:grid-cols-2">
                    <div class="grid gap-2">
                        <label for="provinceId" class="text-sm font-medium text-on-surface">
                            Province <span class="text-danger">*</span>
                        </label>
                        <flux:select
                            id="provinceId"
                            name="provinceId"
                            wire:model.live="provinceId"
                            required
                            class="w-full"
                        >
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
                            <flux:select
                                id="districtId"
                                name="districtId"
                                wire:model.defer="districtId"
                                required
                                class="w-full"
                            >
                                <option value="">Select a district</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}">{{ $district->d_name }}</option>
                                @endforeach
                            </flux:select>
                        @else
                            <flux:select
                                id="districtId"
                                name="districtId"
                                wire:model.defer="districtId"
                                required
                                class="w-full"
                                disabled
                            >
                                <option value="">Select province first</option>
                            </flux:select>
                        @endif
                        @if($errors->first('districtId'))
                            <p class="text-sm text-danger">{{ $errors->first('districtId') }}</p>
                        @endif
                    </div>
                </div>

                <x-ui.input
                    label="Address"
                    name="address"
                    wire:model.defer="address"
                    placeholder="e.g., 123 Main Street"
                    :error="$errors->first('address')"
                />

                <div class="grid gap-6 lg:grid-cols-2">
                    <x-ui.input
                        label="Latitude"
                        name="latitude"
                        type="number"
                        step="0.00000001"
                        wire:model.defer="latitude"
                        placeholder="e.g., 13.7563"
                        :error="$errors->first('latitude')"
                    />

                    <x-ui.input
                        label="Longitude"
                        name="longitude"
                        type="number"
                        step="0.00000001"
                        wire:model.defer="longitude"
                        placeholder="e.g., 100.5018"
                        :error="$errors->first('longitude')"
                    />
                </div>
            </div>

            {{-- Project Details --}}
            <div class="space-y-6">
                <h3 class="text-lg font-semibold text-on-surface border-b border-outline pb-3">
                    Project Details
                </h3>

                <div class="grid gap-6 lg:grid-cols-4">
                    <x-ui.input
                        label="Total Floors"
                        name="totalFloors"
                        type="number"
                        wire:model.defer="totalFloors"
                        placeholder="e.g., 30"
                        min="1"
                        :error="$errors->first('totalFloors')"
                    />

                    <x-ui.input
                        label="Total Units"
                        name="totalUnits"
                        type="number"
                        wire:model.defer="totalUnits"
                        placeholder="e.g., 500"
                        min="1"
                        :error="$errors->first('totalUnits')"
                    />

                    <x-ui.input
                        label="Year Completed"
                        name="yearCompleted"
                        type="number"
                        wire:model.defer="yearCompleted"
                        placeholder="e.g., 2024"
                        min="1900"
                        :max="date('Y') + 10"
                        :error="$errors->first('yearCompleted')"
                    />

                    <div class="grid gap-2">
                        <label for="status" class="text-sm font-medium text-on-surface">
                            Status <span class="text-danger">*</span>
                        </label>
                        <flux:select
                            id="status"
                            name="status"
                            wire:model.defer="status"
                            required
                            class="w-full"
                        >
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </flux:select>
                        @if($errors->first('status'))
                            <p class="text-sm text-danger">{{ $errors->first('status') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="border-t border-outline bg-surface-variant px-8 py-5 flex items-center justify-between">
            <a
                href="{{ route('projects.index') }}"
                wire:navigate
                class="inline-flex items-center gap-2 rounded-radius px-4 py-2 text-sm font-medium bg-surface-variant text-on-surface border border-outline hover:bg-surface hover:border-outline-strong focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all duration-200"
            >
                <flux:icon.arrow-left class="size-4" />
                Cancel
            </a>

            <x-ui.button
                type="submit"
                variant="primary"
            >
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
