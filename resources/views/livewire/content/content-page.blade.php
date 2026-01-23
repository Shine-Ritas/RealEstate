<div>

    @section('action')
        <div class="flex items-center gap-4">
            <livewire:content.content-filter />
        </div>
    @endsection


    <div class="space-y-4">

        @forelse($contents as $content)

            <livewire:content.content-row :content="$content" :key="$content->id" />
        @empty
            <div class="text-center text-on-surface-variant">No contents found</div>
        @endforelse


        {{ $contents->links() }}
    </div>
</div>