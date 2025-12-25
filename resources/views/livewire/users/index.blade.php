<div>
    @section('action')
        <x-ui.button variant="primary" icon="plus"
            onclick="window.dispatchEvent(new CustomEvent('open-user-form', { detail: {} }))">
            Create User
        </x-ui.button>
    @endsection

    <x-ui.modal uid="removeUsers" variant="danger" title="Remove User"
        body="Are you sure you want to remove this User?">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
            @forelse($users as $user)

                <x-ui.card :title="$user->name" :subtitle="$user->email">
                    <x-slot name="actions">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-medium text-on-surface-variant">
                                @if($user->roles->isNotEmpty())
                                    {{ $user->roles->first()->name }}
                                @else
                                    No role
                                @endif
                            </span>
                        </div>
                    </x-slot>

                    <div class="mt-4 flex flex-wrap items-center gap-2">
                        <x-ui.button variant="secondary" icon="pencil" icon-position="left"
                            onclick="window.dispatchEvent(new CustomEvent('open-user-form', { detail: { userId: {{ $user->id }} } }))">
                            Edit
                        </x-ui.button>
                        <x-ui.button variant="danger" x-on:click="removeUsers=true;$wire.setToDelete('{{ $user->id }}')"
                            icon="trash">
                            Delete
                        </x-ui.button>
                    </div>

                </x-ui.card>
            @empty
                <div class="col-span-full">
                    <x-ui.card>
                        <div class="py-12 text-center">
                            <flux:icon.user class="mx-auto size-12 text-on-surface-variant" />
                            <h3 class="mt-4 text-lg font-semibold text-on-surface">No users found</h3>
                            <p class="mt-2 text-sm text-on-surface-variant">Get started by creating a new user.</p>
                            <div class="mt-6">
                                <x-ui.button variant="primary" icon="plus"
                                    onclick="window.dispatchEvent(new CustomEvent('open-user-form', { detail: {} }))">
                                    Create User
                                </x-ui.button>
                            </div>
                        </div>
                    </x-ui.card>
                </div>
            @endforelse
        </div>

        <x-slot:footer>
            <x-ui.button variant="danger" x-on:click="$wire.deleteUser();removeUsers=false">
                Delete
            </x-ui.button>
        </x-slot:footer>
    </x-ui.modal>

    <livewire:users.form />
</div>

