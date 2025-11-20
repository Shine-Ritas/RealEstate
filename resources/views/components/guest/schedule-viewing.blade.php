<div class="bg-white dark:bg-surface-variant rounded-xl p-6 md:p-8 border border-outline">
    <h2 class="text-2xl font-bold text-on-surface mb-6">Schedule a Viewing</h2>
    
    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-success/10 border border-success rounded-lg text-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="scheduleViewing" class="space-y-4">
        <div>
            <label for="name" class="block text-sm font-medium text-on-surface mb-2">Your Name</label>
            <input 
                type="text" 
                id="name"
                wire:model="name"
                class="w-full px-4 py-3 border border-outline rounded-lg bg-surface text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                placeholder="Enter your name"
            >
            @error('name') <span class="text-danger text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-on-surface mb-2">Email Address</label>
            <input 
                type="email" 
                id="email"
                wire:model="email"
                class="w-full px-4 py-3 border border-outline rounded-lg bg-surface text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                placeholder="Enter your email"
            >
            @error('email') <span class="text-danger text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="phone" class="block text-sm font-medium text-on-surface mb-2">Phone Number</label>
            <input 
                type="tel" 
                id="phone"
                wire:model="phone"
                class="w-full px-4 py-3 border border-outline rounded-lg bg-surface text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                placeholder="Enter your phone number"
            >
            @error('phone') <span class="text-danger text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="message" class="block text-sm font-medium text-on-surface mb-2">Message</label>
            <textarea 
                id="message"
                wire:model="message"
                rows="4"
                class="w-full px-4 py-3 border border-outline rounded-lg bg-surface text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent resize-none"
                placeholder="Enter your message"
            ></textarea>
            @error('message') <span class="text-danger text-sm">{{ $message }}</span> @enderror
        </div>

        <button 
            type="submit" 
            class="w-full bg-primary text-on-primary py-3 rounded-lg hover:bg-primary-800 transition-colors font-semibold"
        >
            Schedule Viewing
        </button>
    </form>
</div>

