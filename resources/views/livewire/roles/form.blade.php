<div>
    <div
        x-data="{ show: @js($showModal) }"
        x-show="show"
        x-on:open-role-form.window="show = true; $wire.handleOpenModal($event.detail || {})"
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
                        {{ $roleId ? 'Edit Role' : 'Create Role' }}
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
                            label="Role Name"
                            name="name"
                            wire:model.defer="name"
                            placeholder="e.g., Administrator"
                            required
                            :error="$errors->first('name')"
                        />

                        <x-ui.textarea
                            label="Description"
                            name="description"
                            wire:model.defer="description"
                            placeholder="Optional description for this role"
                            rows="3"
                            :error="$errors->first('description')"
                        />
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
                            {{ $roleId ? 'Update' : 'Create' }} Role
                        </x-ui.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
