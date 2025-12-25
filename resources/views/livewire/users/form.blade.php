<div>
    <div
        x-data="{ show: @js($showModal) }"
        x-effect="show = $wire.showModal"
        x-show="show"
        x-on:open-user-form.window="show = true; $wire.handleOpenModal($event.detail || {})"
        x-on:close-modal.window="show = false"
        x-on:keydown.escape.window="show = false; $wire.closeModal()"
        style="display: none;"
        class="fixed inset-0 z-50 overflow-y-auto"
        role="dialog"
        aria-modal="true"
    >
        <div
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black/50 transition-opacity"
            x-on:click="show = false; $wire.closeModal()"
        ></div>

        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div
                x-show="show"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative transform overflow-hidden rounded-radius bg-surface text-left shadow-xl transition-all max-w-lg w-full"
                x-on:click.stop
            >
                <div class="flex items-center justify-between border-b border-outline px-6 py-4">
                    <h3 class="text-lg font-semibold text-on-surface" id="modal-title">
                        {{ $userId ? 'Edit User' : 'Create User' }}
                    </h3>
                    <button
                        type="button"
                        class="rounded-lg p-1 text-on-surface-variant hover:bg-surface-variant hover:text-on-surface focus:outline-none focus:ring-2 focus:ring-primary"
                        x-on:click="show = false; $wire.closeModal()"
                    >
                        <flux:icon.x-mark class="size-5" />
                    </button>
                </div>

                <form wire:submit="save">
                    <div class="px-6 py-4 space-y-4">
                        <x-ui.input
                            label="Name"
                            name="name"
                            wire:model.defer="name"
                            placeholder="e.g., John Doe"
                            required
                            :error="$errors->first('name')"
                        />

                        <x-ui.input
                            label="Email"
                            name="email"
                            type="email"
                            wire:model.defer="email"
                            placeholder="e.g., john@example.com"
                            required
                            :error="$errors->first('email')"
                        />

                        <x-ui.input
                            label="{{ $userId ? 'Password (leave blank to keep current)' : 'Password' }}"
                            name="password"
                            type="password"
                            wire:model.defer="password"
                            placeholder="Enter password"
                            :required="!$userId"
                            :error="$errors->first('password')"
                        />

                        <x-ui.input
                            label="Confirm Password"
                            name="password_confirmation"
                            type="password"
                            wire:model.defer="password_confirmation"
                            placeholder="Confirm password"
                            :required="!$userId"
                            :error="$errors->first('password_confirmation')"
                        />

                        <div class="grid gap-2">
                            <x-ui.label for="roleId" label="Role" />
                            <flux:select
                                id="roleId"
                                name="roleId"
                                wire:model.defer="roleId"
                                placeholder="Select a role (optional)"
                                class="w-full"
                            >
                                <option value="">Select a role (optional)</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role['value'] }}">{{ $role['label'] }}</option>
                                @endforeach
                            </flux:select>
                            @if($errors->first('roleId'))
                                <p class="text-sm text-danger">{{ $errors->first('roleId') }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="border-t border-outline bg-surface-variant px-6 py-4 flex items-center justify-end gap-3">
                        <x-ui.button
                            type="button"
                            variant="secondary"
                            x-on:click="show = false; $wire.closeModal()"
                        >
                            Cancel
                        </x-ui.button>
                        <x-ui.button
                            type="submit"
                            variant="primary"
                        >
                            {{ $userId ? 'Update' : 'Create' }} User
                        </x-ui.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

