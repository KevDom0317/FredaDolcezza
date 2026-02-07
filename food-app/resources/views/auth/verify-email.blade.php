<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-teal-dark mb-2">Verificar Email</h2>
        <p class="text-sm text-gray-600">Necesitamos verificar tu dirección de email</p>
    </div>

    <div class="mb-4 text-sm text-gray-600">
        {{ __('¡Gracias por registrarte! Antes de comenzar, ¿podrías verificar tu dirección de email haciendo clic en el enlace que acabamos de enviarte? Si no recibiste el email, te enviaremos otro.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 border border-green-200 rounded-md p-3">
            {{ __('Se ha enviado un nuevo enlace de verificación a la dirección de email que proporcionaste durante el registro.') }}
        </div>
    @endif

    <div class="mt-6 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Reenviar Email de Verificación') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-teal-medium hover:text-teal-dark rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-light transition-colors">
                {{ __('Cerrar Sesión') }}
            </button>
        </form>
    </div>
</x-guest-layout>
