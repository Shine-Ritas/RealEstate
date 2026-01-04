<x-layouts.auth>
    <div class="flex flex-col items-center gap-3 w-full">
        <!-- Padlock Icon -->
        <div class="auth-header-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
            </svg>
        </div>

        <!-- Header -->
        <div class="flex flex-col items-center text-center gap-2">
            <h1 class="text-3xl font-bold text-on-surface font-barlow-condensed">{{ __('Welcome back') }}</h1>
            <p class="text-on-surface-variant">{{ __('Sign in to your account to continue') }}</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="text-center w-full" :status="session('status')" />

        <!-- Auth Card -->
        <div class="auth-card w-full max-w-md">
            <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
                @csrf

                <!-- Email Address -->
                <flux:input
                    name="email"
                    :label="__('Username or Email')"
                    type="email"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="{{ __('Enter your username or email') }}"
                />

                <!-- Password -->
                <div class="relative">
                    <flux:input
                        name="password"
                        :label="__('Password')"
                        type="password"
                        required
                        autocomplete="current-password"
                        placeholder="{{ __('Enter your password') }}"
                        viewable
                    />

                    @if (Route::has('password.request'))
                        <flux:link class="absolute top-0 text-sm end-0 auth-link" :href="route('password.request')" wire:navigate>
                            {{ __('Forgot password?') }}
                        </flux:link>
                    @endif
                </div>

                <!-- Sign In Button -->
                <flux:button variant="primary" type="submit" class="w-full flex items-center justify-center gap-2" data-test="login-button">
                    <span>{{ __('Sign in to your account') }}</span>
                   
                </flux:button>
            </form>

            <!-- Social Login Divider -->
            <div class="auth-divider">
                <span>{{ __('Or continue with') }}</span>
            </div>

            <!-- Social Login Buttons -->
    
        </div>

        <!-- Sign Up Link -->
        @if (Route::has('register'))
            <div class="text-sm text-center text-on-surface-variant">
                <span>{{ __('Don\'t have an account?') }}</span>
                <flux:link :href="route('register')" wire:navigate class="auth-link">{{ __('Sign up for free') }}</flux:link>
            </div>
        @endif
    </div>
</x-layouts.auth>
