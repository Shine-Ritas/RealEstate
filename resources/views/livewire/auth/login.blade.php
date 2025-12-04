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
            <div class="flex gap-3">
                <button type="button" class="social-login-button" disabled>
                    <svg class="social-login-icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    <span>Google</span>
                </button>
              
            </div>
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
