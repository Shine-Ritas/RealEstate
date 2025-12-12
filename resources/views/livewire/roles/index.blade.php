<div>
    @section('action')
        <x-ui.button variant="primary" icon="plus"
            onclick="window.dispatchEvent(new CustomEvent('open-role-form', { detail: {} }))">
            Create Role
        </x-ui.button>
    @endsection

    <x-ui.modal uid="removeRoles" variant="danger" title="Remove Role"
        body="Are you sure you want to remove this Role?">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
            @forelse($roles as $role)

                <x-ui.card :title="ucfirst($role->name)" :subtitle="$role->description ?? 'No description'">
                    <x-slot name="actions">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-medium text-on-surface-variant">
                                {{ $role->permissions_count }}
                                {{ $role->permissions_count === 1 ? 'permission' : 'permissions' }}
                            </span>
                        </div>
                    </x-slot>

                    <div class="mt-4 flex flex-wrap items-center gap-2">
                        <x-ui.button variant="secondary" icon="cog-6-tooth" icon-position="left"
                            href="{{ route('roles.permissions', $role->id) }}">
                            Permissions
                        </x-ui.button>
                        <x-ui.button variant="secondary" icon="pencil" icon-position="left"
                            onclick="window.dispatchEvent(new CustomEvent('open-role-form', { detail: { roleId: {{ $role->id }} } }))">
                            Edit
                        </x-ui.button>
                        <x-ui.button variant="danger" x-on:click="removeRoles=true;$wire.setToDelete('{{ $role->id }}')"
                            icon="trash">
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
                                <x-ui.button variant="primary" icon="plus"
                                    onclick="window.dispatchEvent(new CustomEvent('open-role-form', { detail: {} }))">
                                    Create Role
                                </x-ui.button>
                            </div>
                        </div>
                    </x-ui.card>
                </div>
            @endforelse
        </div>

        <x-slot:footer>
            <x-ui.button variant="danger" x-on:click="$wire.deleteRole();removeRoles=false">
                Delete Shit
            </x-ui.button>
        </x-slot:footer>
    </x-ui.modal>

    <livewire:roles.form />
</div>