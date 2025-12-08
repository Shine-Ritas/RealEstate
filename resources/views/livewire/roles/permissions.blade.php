<div>
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-on-surface">Manage Permissions</h1>
                <p class="mt-1 text-sm text-on-surface-variant">
                    Role: <span class="font-semibold">{{ $role->name }}</span>
                </p>
            </div>
            <div class="flex items-center gap-3">
                <x-ui.button
                    variant="secondary"
                    icon="arrow-left"
                    icon-position="left"
                    wire:navigate
                    href="{{ route('roles.index') }}"
                >
                    Back to Roles
                </x-ui.button>
                <x-ui.button
                    variant="primary"
                    icon="check"
                    icon-position="left"
                    wire:click="savePermissions"
                >
                    Save Permissions
                </x-ui.button>
            </div>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 rounded-radius bg-success/10 border border-success/20 px-4 py-3 text-sm text-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="space-y-6">
        @foreach($permissions as $module => $modulePermissions)
            <x-ui.card
                :title="ucfirst(str_replace('_', ' ', $module))"
                :subtitle="count($modulePermissions) . ' ' . (count($modulePermissions) === 1 ? 'permission' : 'permissions')"
            >
                <div class="grid grid-cols-1 gap-3 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($modulePermissions as $permission)
                        <label class="flex items-center gap-3 rounded-lg border border-outline p-3 cursor-pointer transition-all hover:bg-surface-variant hover:border-outline-strong">
                            <input
                                type="checkbox"
                                wire:model.live="selectedPermissions"
                                value="{{ $permission->id }}"
                                class="size-4 rounded border-outline text-primary focus:ring-primary"
                            />
                            <span class="flex-1 text-sm font-medium text-on-surface">
                                {{ $permission->name }}
                            </span>
                        </label>
                    @endforeach
                </div>
            </x-ui.card>
        @endforeach
    </div>
</div>
