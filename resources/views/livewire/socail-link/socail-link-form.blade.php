<div class="w-full">
    @if (session()->has('message'))
        <div class="mb-6 rounded-radius bg-success/10 border border-success/20 px-4 py-3 text-sm text-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit="save" class="space-y-6">
        {{-- Basic Information --}}
        <x-ui.accordian title="Basic Information" open class="relative h-full" icon="link">
            <div class="grid gap-6 lg:grid-cols-2">
                <x-ui.input 
                    label="Social Link Name" 
                    name="name" 
                    wire:model.live="name"
                    placeholder="e.g., Facebook, Twitter, Instagram" 
                    required 
                    :error="$errors->first('name')" 
                    bold 
                />

                <x-ui.input 
                    label="URL" 
                    name="url" 
                    wire:model.live="url"
                    type="url"
                    placeholder="https://example.com" 
                    required 
                    :error="$errors->first('url')" 
                    bold 
                />

                <div class="grid gap-2">
                    <x-ui.label for="status" label="Status" required bold />
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
        </x-ui.accordian>

        {{-- Display Type Selection --}}
        <x-ui.accordian title="Display Options" open icon="photo">
            <div class="space-y-6">
                <div class="grid gap-2">
                    <x-ui.label for="displayType" label="Display Type" required bold />
                    <flux:select
                        id="displayType"
                        name="displayType"
                        wire:model.live="displayType"
                        required
                        class="w-full"
                    >
                        <option value="icon">Icon (Font Awesome)</option>
                        <option value="photo">Photo/Image</option>
                    </flux:select>
                    @if($errors->first('displayType'))
                        <p class="text-sm text-danger">{{ $errors->first('displayType') }}</p>
                    @endif
                </div>

                {{-- Icon Input --}}
                <div x-show="$wire.displayType === 'icon'" class="space-y-4">
                    <div class="grid gap-2">
                        <label for="icon" class="text-sm font-medium text-on-surface">
                            Icon Name <span class="text-danger">*</span>
                            <span class="text-xs text-on-surface-variant font-normal">(Font Awesome icon name, e.g., facebook, twitter, instagram)</span>
                        </label>
                        <div class="flex items-center gap-3">
                            <flux:input
                                id="icon"
                                name="icon"
                                wire:model.live="icon"
                                placeholder="e.g., facebook"
                                required
                                class="flex-1"
                            />
                            <div class="flex size-12 items-center justify-center rounded-lg text-white {{ $icon ? 'bg-primary/80' : 'bg-surface-variant border border-outline' }}">
                                @if($icon)
                                    <x-ui.icon-preview :name="$icon" size="size-6" />
                                @else
                                    <flux:icon.sparkles class="size-6 text-on-surface-variant" />
                                @endif
                            </div>
                        </div>
                        @if($errors->first('icon'))
                            <p class="text-sm text-danger">{{ $errors->first('icon') }}</p>
                        @endif
                    </div>
                </div>

                {{-- Photo Upload --}}
                <div x-show="$wire.displayType === 'photo'" class="space-y-4" x-cloak>
                    <div class="grid gap-2">
                        <label for="photo" class="text-sm font-medium text-on-surface">
                            Photo <span class="text-danger">*</span>
                            <span class="text-xs text-on-surface-variant font-normal">(Max 2MB, JPG, PNG, GIF)</span>
                        </label>
                        
                        @if($photoUrl && !$photo)
                            <div class="mb-4">
                                <p class="text-sm text-on-surface-variant mb-2">Current Photo:</p>
                                <div class="relative inline-block">
                                    <img 
                                        src="{{ Storage::url($photoUrl) }}" 
                                        alt="{{ $name }}"
                                        class="h-24 w-24 object-cover rounded-lg border-2 border-outline"
                                    >
                                </div>
                            </div>
                        @endif

                        @if($photo)
                            <div class="mb-4">
                                <p class="text-sm text-on-surface-variant mb-2">New Photo Preview:</p>
                                <div class="relative inline-block">
                                    <img 
                                        src="{{ $photo->temporaryUrl() }}" 
                                        alt="Preview"
                                        class="h-24 w-24 object-cover rounded-lg border-2 border-primary"
                                    >
                                </div>
                            </div>
                        @endif

                        <div 
                            @click="$refs.photoInput.click()"
                            class="border-2 border-dashed rounded-lg p-6 text-center cursor-pointer transition-all duration-200 hover:border-primary hover:bg-primary/5 {{ $errors->first('photo') ? 'border-danger' : 'border-outline' }}"
                        >
                            <input 
                                type="file" 
                                x-ref="photoInput"
                                wire:model="photo"
                                accept="image/*"
                                class="hidden"
                            >
                            <flux:icon.photo class="mx-auto size-8 text-on-surface-variant mb-2" />
                            <p class="text-sm text-on-surface">
                                <span class="font-semibold">Click to upload</span> or drag and drop
                            </p>
                            <p class="mt-1 text-xs text-on-surface-variant">
                                PNG, JPG, GIF up to 2MB
                            </p>
                        </div>
                        
                        @if($errors->first('photo'))
                            <p class="text-sm text-danger">{{ $errors->first('photo') }}</p>
                        @endif

                        <div wire:loading wire:target="photo" class="text-sm text-on-surface-variant">
                            Uploading...
                        </div>
                    </div>
                </div>
            </div>
        </x-ui.accordian>

        {{-- Action Buttons --}}
        <div class="bg-surface rounded-radius border border-outline shadow-sm px-8 py-5 flex items-center justify-between">
            <a href="{{ route('social-links.index') }}" wire:navigate class="btn btn-danger">
                Cancel
            </a>

            <x-ui.button type="submit" variant="primary">
                <span wire:loading.remove wire:target="save">
                    {{ $socialLinkId ? 'Update' : 'Create' }} Social Link
                </span>
                <span wire:loading wire:target="save">
                    {{ $socialLinkId ? 'Updating...' : 'Creating...' }}
                </span>
            </x-ui.button>
        </div>
    </form>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</div>

