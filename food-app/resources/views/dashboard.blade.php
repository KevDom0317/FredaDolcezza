<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-2 border-teal-light">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4 text-teal-dark">¡Bienvenido!</h1>
                    <p class="mb-6 text-gray-600">{{ __("Estás conectado.") }}</p>
                    
                    @if(auth()->user()->role === 'admin')
                        <div class="mt-4">
                            <a href="{{ route('admin.index') }}" class="inline-flex items-center px-4 py-2 bg-teal-gradient hover:opacity-90 text-white font-semibold rounded-lg transition-all shadow-md hover:shadow-lg">
                                Ir al Panel de Administración
                            </a>
                        </div>
                    @else
                        <div class="mt-4">
                            <a href="{{ route('menu.index') }}" class="inline-flex items-center px-4 py-2 bg-teal-gradient hover:opacity-90 text-white font-semibold rounded-lg transition-all shadow-md hover:shadow-lg">
                                Ver Menú
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
