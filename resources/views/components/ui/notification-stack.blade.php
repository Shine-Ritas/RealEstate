<div x-data="{
    notifications: [
        @if(session()->has('success'))
            {
                id: Date.now(),
                variant: 'success',
                title: 'Success',
                message: '{{ session()->get('success') }}'
            }
        @endif
        @if(session()->has('error'))
            {
                id: Date.now(),
                variant: 'danger',
                title: 'Error',
                message: '{{ session()->get('error') }}'
            }
        @endif
        @if(session()->has('warning'))
            {
                id: Date.now(),
                variant: 'warning',
                title: 'Warning',
                message: '{{ session()->get('warning') }}'
            }
        @endif
        @if(session()->has('info'))
            {
                id: Date.now(),
                variant: 'info',
                title: 'Info',
                message: '{{ session()->get('info') }}'
            }
        @endif
        ],
    displayDuration: 3000,
    soundEffect: false,

    addNotification(detail) {
        detail = detail[0]

        const id = Date.now();
        const notification = {
            id,
            variant: detail.variant || 'info',
            sender: detail.sender || null,
            title: detail.title || 'No Title',
            message: detail.message || 'No Message',
        };

        if (this.notifications.length >= 20) {
            this.notifications.splice(0, this.notifications.length - 19);
        }

        this.notifications.push(notification);

        if (this.soundEffect) {
            const sound = new Audio('https://res.cloudinary.com/ds8pgw1pf/video/upload/v1728571480/penguinui/component-assets/sounds/ding.mp3');
            sound.play().catch(console.error);
        }
    },

    removeNotification(id) {
        setTimeout(() => {
            this.notifications = this.notifications.filter(n => n.id !== id);
        }, 400);
    },
}"

x-on:notify.window="addNotification($event.detail)"
>

    <div x-on:mouseenter="$dispatch('pause-auto-dismiss')" x-on:mouseleave="$dispatch('resume-auto-dismiss')" class="group pointer-events-none fixed inset-x-8 top-0 z-99 flex max-w-full flex-col gap-2 bg-transparent px-6 py-6 md:bottom-[unset] md:left-[unset] md:right-0 md:top-0 md:max-w-sm">
        <template x-for="notification in notifications" :key="notification.id">
            <div x-data="{ isVisible: false, timeout: null }" x-show="isVisible" x-cloak
                 x-transition:enter="transition duration-300 ease-out"
                 x-transition:enter-start="translate-y-8"
                 x-transition:enter-end="translate-y-0"
                 x-transition:leave="transition duration-300 ease-in"
                 x-transition:leave-start="translate-x-0 opacity-100"
                 x-transition:leave-end="-translate-x-24 opacity-0 md:translate-x-24"
                 x-init="$nextTick(() => {
                    isVisible = true;
                    timeout = setTimeout(() => { isVisible = false; removeNotification(notification.id) }, displayDuration);
                 })"
                 x-on:pause-auto-dismiss.window="clearTimeout(timeout)"
                 x-on:resume-auto-dismiss.window="timeout = setTimeout(() => { isVisible = false; removeNotification(notification.id) }, displayDuration)"
                 :class="{
                     'border-info bg-surface text-on-surface dark:bg-surface-dark dark:text-on-surface-dark': notification.variant === 'info',
                     'border-success bg-surface text-on-surface dark:bg-surface-dark dark:text-on-surface-dark': notification.variant === 'success',
                     'border-danger bg-surface text-on-surface dark:bg-surface-dark dark:text-on-surface-dark': notification.variant === 'danger',
                     'border-warning bg-surface text-on-surface dark:bg-surface-dark dark:text-on-surface-dark': notification.variant === 'warning',
                     'border-primary bg-surface text-on-surface dark:bg-surface-dark dark:text-on-surface-dark': notification.variant === 'message',
                 }"
                 class="pointer-events-auto relative rounded-radius border">

                <div :class="{
                        'bg-info/10 text-info': notification.variant === 'info',
                        'bg-success/10 text-success': notification.variant === 'success',
                        'bg-danger/10 text-danger': notification.variant === 'danger',
                        'bg-warning/10 text-warning': notification.variant === 'warning',
                        'bg-primary/10 text-primary': notification.variant === 'message',
                    }" class="flex w-full items-center gap-2.5 rounded-radius p-4">

                    <!-- Icon -->
                    <div :class="{
                        'bg-info/15 text-info': notification.variant === 'info',
                        'bg-success/15 text-success': notification.variant === 'success',
                        'bg-danger/15 text-danger': notification.variant === 'danger',
                        'bg-warning/15 text-warning': notification.variant === 'warning',
                        'bg-primary/15 text-primary': notification.variant === 'message',
                    }" class="rounded-full p-0.5" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" class="size-5">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.06l2.5 2.5a.75.75 0 0 0 1.134-.088l4-5.5Z" clip-rule="evenodd" />
                        </svg>
                    </div>

                    <!-- Title & Message -->
                    <div class="flex flex-col gap-2">
                        <h3 x-show="notification.title" class="text-sm font-semibold" x-text="notification.title"></h3>
                        <p x-show="notification.message" class="text-sm" x-text="notification.message"></p>
                    </div>

                    <!-- Dismiss -->
                    <button type="button" class="ml-auto" aria-label="dismiss notification" x-on:click="isVisible = false; removeNotification(notification.id)">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                </div>
            </div>
        </template>
    </div>
    
</div>


