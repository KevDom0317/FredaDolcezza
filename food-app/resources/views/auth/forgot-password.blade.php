<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-teal-dark mb-2">Recuperar Contraseña</h2>
        <p class="text-sm text-gray-600">Ingresa tu email y te enviaremos un enlace para restablecer tu contraseña</p>
    </div>

    <div class="mb-4 text-sm text-gray-600">
        {{ __('¿Olvidaste tu contraseña? No hay problema. Solo ingresa tu dirección de email y te enviaremos un enlace para restablecer tu contraseña.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
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
                autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a href="{{ route('login') }}" class="text-sm text-teal-medium hover:text-teal-dark underline transition-colors">
                ← Volver al login
            </a>
            <x-primary-button>
                {{ __('Enviar Enlace') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
