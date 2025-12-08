<div>
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-on-surface">Role Management</h1>
            <p class="mt-1 text-sm text-on-surface-variant">Manage user roles and their permissions</p>
        </div>
        <x-ui.button
            variant="primary"
            icon="plus"
            onclick="window.dispatchEvent(new CustomEvent('open-role-form', { detail: {} }))"
        >
            Create Role
        </x-ui.button>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 rounded-radius bg-success/10 border border-success/20 px-4 py-3 text-sm text-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
        @forelse($roles as $role)
            <x-ui.card
                :title="ucfirst($role->name)"
                :subtitle="$role->description ?? 'No description'"
            >
                <x-slot name="actions">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-medium text-on-surface-variant">
                            {{ $role->permissions_count }} {{ $role->permissions_count === 1 ? 'permission' : 'permissions' }}
                        </span>
                    </div>
                </x-slot>

                <div class="mt-4 flex flex-wrap items-center gap-2">
                    <x-ui.button
                        variant="secondary"
                        icon="cog-6-tooth"
                        icon-position="left"
                        href="{{ route('roles.permissions', $role->id) }}"
                    >
                        Permissions
                    </x-ui.button>
                    <x-ui.button
                        variant="secondary"
                        icon="pencil"
                        icon-position="left"
                        onclick="window.dispatchEvent(new CustomEvent('open-role-form', { detail: { roleId: {{ $role->id }} } }))"
                    >
                        Edit
                    </x-ui.button>
                    <x-ui.button
                        variant="danger"
                        icon="trash"
                        icon-position="left"
                        wire:click="openDeleteModal({{ $role->id }})"
                    >
                        Delete
                    </x-ui.button>
                </div>
            </x-ui.card>
        @empty
            <div class="col-span-full">
                <x-ui.card>
                    <div class="py-12 text-center">
                        <flux:icon.user-group class="mx-auto size-12 text-on-surface-variant" />
                        <h3 class="mt-4 text-lg font-semibold text-on-surface">No roles found</h3>
                        <p class="mt-2 text-sm text-on-surface-variant">Get started by creating a new role.</p>
                        <div class="mt-6">
                            <x-ui.button
                                variant="primary"
                                icon="plus"
                                onclick="window.dispatchEvent(new CustomEvent('open-role-form', { detail: {} }))"
                            >
                                Create Role
                            </x-ui.button>
                        </div>
                    </div>
                </x-ui.card>
            </div>
        @endforelse
    </div>

    <livewire:roles.form />

    <div
        x-data="{ show: @js($showDeleteModal) }"
        x-show="show"
        x-on:keydown.escape.window="show = false; $wire.closeDeleteModal()"
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
            x-on:click="show = false; $wire.closeDeleteModal()"
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
                class="relative transform overflow-hidden rounded-radius bg-surface text-left shadow-xl transition-all max-w-md w-full"
                x-on:click.stop
            >
                <div class="px-6 py-4">
                    <h3 class="text-lg font-semibold text-on-surface mb-2">
                        Delete Role
                    </h3>
                    <p class="text-sm text-on-surface-variant">
                        @if($roleToDelete)
                            Are you sure you want to delete the role "<strong>{{ $roleToDelete->name }}</strong>"? This action cannot be undone.
                        @endif
                    </p>
                </div>

                <div class="border-t border-outline bg-surface-variant px-6 py-4 flex items-center justify-end gap-3">
                    <x-ui.button
                        variant="secondary"
                        x-on:click="show = false; $wire.closeDeleteModal()"
                    >
                        Cancel
                    </x-ui.button>
                    <x-ui.button
                        variant="danger"
                        wire:click="deleteRole"
                        x-on:click="show = false"
                    >
                        Delete
                    </x-ui.button>
                </div>
            </div>
        </div>
    </div>
</div>
