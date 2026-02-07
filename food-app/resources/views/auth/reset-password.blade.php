<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-teal-dark mb-2">Restablecer Contraseña</h2>
        <p class="text-sm text-gray-600">Ingresa tu nueva contraseña</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-teal-dark" />
            <x-text-input id="email" 
                class="block mt-1 w-full border-teal-light focus:border-teal-medium focus:ring-teal" 
                type="email" 
                name="email" 
                :value="old('email', $request->email)" 
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
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" class="text-teal-dark" />

            <x-text-input id="password_confirmation" 
                class="block mt-1 w-full border-teal-light focus:border-teal-medium focus:ring-teal"
                type="password"
                name="password_confirmation" 
                required 
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <x-primary-button>
                {{ __('Restablecer Contraseña') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
