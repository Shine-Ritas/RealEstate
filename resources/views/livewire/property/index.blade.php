<div>
    {{-- The whole world belongs to you. --}}

    @section('action')
            <a href="{{ route('projects.create') }}" class="btn btn-primary" wire:navigate>
                New Project
            </a>
    @endsection


</div>