<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="bg-white/30 dark:bg-white/20 backdrop-blur-lg shadow-lg rounded-lg p-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-black-600 dark:text-black-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-center mt-4">
    <a href="{{ route('redirect.google') }}" class="bg-white border border-gray-300 shadow-sm text-gray-700 font-bold py-2 px-4 rounded flex items-center hover:bg-gray-100">
        <!-- Google SVG Icon -->
        <svg class="w-6 h-6 mr-2" viewBox="0 0 48 48">
            <path fill="#EA4335" d="M24 9.5c3.14 0 5.95 1.08 8.17 2.85l6.1-6.1C34.78 3.31 29.68 1 24 1 14.92 1 7.17 6.58 3.9 14.01l7.12 5.53C12.75 13.35 17.92 9.5 24 9.5z"/>
            <path fill="#4285F4" d="M46.5 24.5c0-1.7-.15-3.33-.43-4.9H24v9.3h12.7c-.55 2.95-2.17 5.45-4.6 7.15l7.08 5.5c4.13-3.8 6.52-9.43 6.52-15.05z"/>
            <path fill="#FBBC05" d="M10.9 28.54a14.55 14.55 0 010-9.1L3.8 13.9A23.96 23.96 0 001 24c0 3.9.93 7.6 2.8 10.9l7.1-6.36z"/>
            <path fill="#34A853" d="M24 47c6.48 0 11.92-2.13 15.9-5.8l-7.08-5.5C30.94 37.2 27.66 38.5 24 38.5c-6.07 0-11.24-3.85-13.1-9.03l-7.13 5.53C7.18 41.42 14.93 47 24 47z"/>
            <path fill="none" d="M1 1h46v46H1z"/>
        </svg>
        Sign in with Google
    </a>
</div>


        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-black-600 dark:text-black-400 hover:text-black-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>



        </div>
    </form>
</x-guest-layout>
