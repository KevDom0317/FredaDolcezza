<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-teal-dark mb-2">Iniciar Sesión</h2>
        <p class="text-sm text-gray-600">Accede a tu cuenta para continuar</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-teal-dark" />
            <x-text-input id="email" 
                class="block mt-1 w-full border-teal-light focus:border-teal-medium focus:ring-teal" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autofocus 
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" class="text-teal-dark" />

            <x-text-input id="password" 
                class="block mt-1 w-full border-teal-light focus:border-teal-medium focus:ring-teal"
                type="password"
                name="password"
                required 
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" 
                    type="checkbox" 
                    class="rounded border-teal-light text-teal-dark shadow-sm focus:ring-teal focus:ring-offset-0" 
                    name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Recordarme') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-teal-medium hover:text-teal-dark rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-light transition-colors" 
                   href="{{ route('password.request') }}">
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Iniciar Sesión') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-6 pt-6 border-t border-teal-pastel">
        <p class="text-center text-sm text-gray-600">
            ¿No tienes una cuenta?
            <a href="{{ route('register') }}" class="text-teal-medium hover:text-teal-dark font-medium underline transition-colors">
                Regístrate aquí
            </a>
        </p>
    </div>
</x-guest-layout>
