<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-teal-dark mb-2">Confirmar Contraseña</h2>
        <p class="text-sm text-gray-600">Esta es un área segura de la aplicación</p>
    </div>

    <div class="mb-4 text-sm text-gray-600">
        {{ __('Esta es un área segura de la aplicación. Por favor confirma tu contraseña antes de continuar.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Contraseña')" class="text-teal-dark" />

            <x-text-input id="password" 
                class="block mt-1 w-full border-teal-light focus:border-teal-medium focus:ring-teal"
                type="password"
                name="password"
                required 
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-6">
            <x-primary-button>
                {{ __('Confirmar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
