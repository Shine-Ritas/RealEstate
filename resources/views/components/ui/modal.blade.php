<!-- Base Modal Component -->

@props([
    'variant' => "success",
    'uid' => "successModalIsOpen",
    'title' => "Transaction Complete",
    'body' => "Your funds transfer was successful. Check your balance for confirmation.",
    'size' => "lg",
    'default' => 'false'
])

@php
    $variantClasses = [
        'success' => [
            'icon' => '<path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />',
            'iconBg' => 'bg-success/20 text-success',
            'button' => 'border-success bg-success text-on-success focus-visible:outline-success',
        ],
        'info' => [
            'icon' => '<path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM9 9a.75.75 0 0 0 0 1.5h.253a.25.25 0 0 1 .244.304l-.459 2.066A1.75 1.75 0 0 0 10.747 15H11a.75.75 0 0 0 0-1.5h-.253a.25.25 0 0 1-.244-.304l.459-2.066A1.75 1.75 0 0 0 9.253 9H9Z" clip-rule="evenodd" />',
            'iconBg' => 'bg-primary/20 text-primary',
            'button' => 'border-primary bg-primary text-on-primary focus-visible:outline-primary',
        ],
        'warning' => [
            'icon' => '<path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />',
            'iconBg' => 'bg-warning/20 text-warning',
            'button' => 'border-warning bg-warning text-on-warning focus-visible:outline-warning',
        ],
        'danger' => [
            'icon' => '<path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z" clip-rule="evenodd" />',
            'iconBg' => 'bg-danger/20 text-danger',
            'button' => 'border-danger bg-danger text-on-danger focus-visible:outline-danger',
        ],
    ];

    $currentVariant = $variantClasses[$variant] ?? $variantClasses['success'];
@endphp

<div x-data="{ {{ $uid }}: {{ $default }} }">
    {{ $slot }}
    <div x-cloak x-show="{{ $uid }}" x-transition.opacity.duration.200ms x-trap.inert.noscroll="{{ $uid }}" x-on:keydown.esc.window="{{ $uid }} = false" x-on:click.self="{{ $uid }} = false" class="fixed inset-0 z-60 flex items-center justify-center bg-black/20 p-4 pb-8 backdrop-blur-md  lg:p-8" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <!-- Modal Dialog -->
        <div x-show="{{ $uid }}" x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity" x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100" class="flex w-lg flex-col gap-4 overflow-hidden rounded-radius border border-outline bg-surface text-on-surface">
            <!-- Dialog Header -->
            <div class="flex items-center justify-between border-b border-outline bg-surface-alt/60 px-4 py-2">
                <div class="flex items-center justify-center rounded-full {{ $currentVariant['iconBg'] }} p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-6" aria-hidden="true">
                        {!! $currentVariant['icon'] !!}
                    </svg>
                </div>
                <button x-on:click="{{ $uid }} = false" aria-label="close modal">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none" stroke-width="1.4" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <!-- Dialog Body -->
            <div class="px-4 text-center"> 
                <h3 id="modalTitle" class="mb-2 font-semibold tracking-wide text-on-surface-strong">{{ $title }}</h3>
                @if(isset($htmlBody))
                    {!! $htmlBody !!}
                @endif
                @if(isset($body))
                    {!! $body !!}
                @endif
            </div>
            <!-- Dialog Footer -->
            <div class="flex items-center justify-center border-outline p-4 dark:border-outline-dark">
                @if(isset($footer))
                    {!! $footer !!}
                @else
                <button x-on:click="{{ $uid }} = false" type="button" class="w-full whitespace-nowrap rounded-radius border {{ $currentVariant['button'] }} px-4 py-2 text-center text-sm font-semibold tracking-wide transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 active:opacity-100 active:outline-offset-0">Delete</button>
                @endif
            </div>
        </div>
    </div>
</div>

