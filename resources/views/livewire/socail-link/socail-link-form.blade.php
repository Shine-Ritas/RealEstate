<div class="w-full">
    @if (session()->has('message'))
        <div class="mb-4 rounded-radius bg-success/10 border border-success/20 px-4 py-2.5 text-sm text-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit="save">
        <div class="bg-surface rounded-radius border border-outline shadow-sm overflow-hidden">
            {{-- Form Header --}}
            <div class="border-b border-outline bg-surface-variant/30 px-6 py-4">
                <h3 class="text-base font-semibold text-on-surface">Social Link Details</h3>
            </div>

            <div class="p-6 space-y-6">
                {{-- Basic Fields Row --}}
                <div class="grid gap-4 lg:grid-cols-3">
                    <x-ui.input 
                        label="Social Link Name" 
                        name="name" 
                        wire:model.live="name"
                        placeholder="e.g., Facebook, Twitter" 
                        required 
                        :error="$errors->first('name')" 
                        bold 
                    />

                    <x-ui.input 
                        label="URL" 
                        name="url" 
                        wire:model.live="url"
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
                        <x-ui.form-error name="status" />
                    </div>
                </div>

                {{-- Divider --}}
                <div class="border-t border-outline"></div>

                {{-- Display Type Toggle --}}
                <div class="space-y-3">
                    <x-ui.label label="Display Type" required bold />
                    <div class="flex gap-3">
                        <label class="flex-1 cursor-pointer">
                            <input 
                                type="radio" 
                                name="displayType" 
                                value="icon" 
                                wire:model.live="displayType"
                                class="hidden"
                            >
                            <div class="flex items-center justify-center gap-2 px-4 py-3 rounded-radius border-2 transition-all {{ $displayType === 'icon' ? 'border-primary bg-primary/5 text-primary' : 'border-outline bg-surface text-on-surface' }}">
                                <flux:icon.photo class="size-4" />
                                <span class="text-sm font-medium">Icon</span>
                            </div>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input 
                                type="radio" 
                                name="displayType" 
                                value="photo" 
                                wire:model.live="displayType"
                                class="hidden"
                            >
                            <div class="flex items-center justify-center gap-2 px-4 py-3 rounded-radius border-2 transition-all {{ $displayType === 'photo' ? 'border-primary bg-primary/5 text-primary' : 'border-outline bg-surface text-on-surface' }}">
                                <flux:icon.photo class="size-4" />
                                <span class="text-sm font-medium">Photo</span>
                            </div>
                        </label>
                    </div>
                    <x-ui.form-error name="displayType" />
                </div>

                {{-- Icon Input Section --}}
                <div x-show="$wire.displayType === 'icon'" x-transition x-cloak class="space-y-3">
                    <div class="flex items-start gap-4 p-4 bg-surface-variant/30 rounded-radius border border-outline">
                        <div class="flex-1">
                            <x-ui.label for="icon" label="Icon Name" required bold />
                            <p class="text-xs text-on-surface-variant mt-1 mb-3">
                                Font Awesome icon name (e.g., facebook, twitter, instagram)
                            </p>
                            <flux:input
                                id="icon"
                                name="icon"
                                wire:model.live="icon"
                                placeholder="e.g., facebook"
                                x-bind:required="$wire.displayType === 'icon'"
                                class="w-full"
                            />
                            <x-ui.form-error name="icon" />
                        </div>
                        @if($icon)
                            <div class="flex flex-col items-center gap-2 p-3 bg-surface rounded-radius border border-outline min-w-[100px]">
                                <i class="fa-brands fa-{{ $icon }} text-3xl text-primary"></i>
                                <span class="text-xs text-on-surface-variant">fa-{{ $icon }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Photo Upload Section --}}
                <div x-show="$wire.displayType === 'photo'" x-transition x-cloak class="space-y-3">
                    <div class="p-4 bg-surface-variant/30 rounded-radius border border-outline">
                        <x-ui.label for="photo" label="Photo" required bold />
                        <p class="text-xs text-on-surface-variant mt-1 mb-4">
                            Maximum file size: 2MB. Supported formats: JPG, PNG, GIF
                        </p>

                        <div class="grid gap-4 lg:grid-cols-2">
                            {{-- Current Photo --}}
                            @if($photoUrl && !$photo)
                                <div class="space-y-2">
                                    <p class="text-xs font-medium text-on-surface-variant">Current Photo</p>
                                    <div class="relative inline-block">
                                        <img 
                                            src="{{ Storage::url($photoUrl) }}" 
                                            alt="{{ $name }}"
                                            class="h-24 w-24 object-cover rounded-radius border-2 border-outline"
                                        >
                                    </div>
                                </div>
                            @endif

                            {{-- New Photo Preview --}}
                            @if($photo)
                                <div class="space-y-2">
                                    <p class="text-xs font-medium text-primary">New Photo Preview</p>
                                    <div class="relative inline-block">
                                        <img 
                                            src="{{ $photo->temporaryUrl() }}" 
                                            alt="Preview"
                                            class="h-24 w-24 object-cover rounded-radius border-2 border-primary"
                                        >
                                    </div>
                                </div>
                            @endif

                            {{-- Upload Area --}}
                            <div 
                                @click="$refs.photoInput.click()"
                                class="relative border-2 border-dashed rounded-radius p-4 text-center cursor-pointer transition-all duration-200 hover:border-primary hover:bg-primary/5 {{ $errors->first('photo') ? 'border-danger bg-danger/5' : 'border-outline' }}"
                            >
                                <input 
                                    type="file" 
                                    x-ref="photoInput"
                                    wire:model="photo"
                                    accept="image/jpeg,image/png,image/gif"
                                    class="hidden"
                                >
                                <div class="flex flex-col items-center gap-2">
                                    <flux:icon.photo class="size-8 text-on-surface-variant" />
                                    <div>
                                        <p class="text-xs font-medium text-on-surface">
                                            <span class="text-primary">Click to upload</span>
                                        </p>
                                        <p class="mt-0.5 text-xs text-on-surface-variant">
                                            or drag and drop
                                        </p>
                                        <p class="mt-1 text-xs text-on-surface-variant">
                                            PNG, JPG, GIF up to 2MB
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <x-ui.form-error name="photo" />

                        <div wire:loading wire:target="photo" class="mt-3 flex items-center gap-2 text-xs text-primary">
                            <svg class="animate-spin size-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Uploading...</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons Footer --}}
            <div class="border-t border-outline bg-surface-variant/30 px-6 py-4 flex items-center justify-end gap-3">
                <a 
                    href="{{ route('social-links.index') }}" 
                    wire:navigate 
                    class="inline-flex items-center justify-center gap-2 rounded-radius px-4 py-2 text-sm font-medium transition-all duration-200 bg-surface text-on-surface border border-outline hover:bg-surface-variant hover:border-outline-strong focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                >
                    Cancel
                </a>

                <x-ui.button type="submit" variant="primary">
                    <span wire:loading.remove wire:target="save">
                        {{ $socialLinkId ? 'Update' : 'Create' }} Social Link
                    </span>
                    <span wire:loading wire:target="save" class="flex items-center gap-2">
                        <svg class="animate-spin size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        {{ $socialLinkId ? 'Updating...' : 'Creating...' }}
                    </span>
                </x-ui.button>
            </div>
        </div>
    </form>
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
</div>

