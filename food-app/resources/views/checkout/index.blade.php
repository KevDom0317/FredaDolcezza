@php
use Illuminate\Support\Facades\Storage;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout - {{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --teal-dark: #345b63;
            --teal-medium: #4a7c8a;
            --teal-light: #7fb3c3;
            --teal-pastel: #b8d4dc;
        }
        .bg-teal-gradient {
            background: linear-gradient(135deg, var(--teal-dark) 0%, var(--teal-medium) 50%, var(--teal-light) 100%);
        }
        .text-teal-dark { color: var(--teal-dark); }
        .text-teal-medium { color: var(--teal-medium); }
        .border-teal-light { border-color: var(--teal-light); }
        .border-teal-medium { border-color: var(--teal-medium); }
    </style>
</head>
<body class="font-sans antialiased">
    <!-- Fondo con gradiente -->
    <div class="fixed inset-0 z-0 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-[#b8d4dc] via-[#7fb3c3] to-[#4a7c8a] opacity-50"></div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjQwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZGVmcz48cGF0dGVybiBpZD0iYSIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIj48Y2lyY2xlIGN4PSIyMCIgY3k9IjIwIiByPSIyIiBmaWxsPSIjMzQ1YjYzIiBmaWxsLW9wYWNpdHk9IjAuMSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0idXJsKCNhKSIvPjwvc3ZnPg==')] opacity-20"></div>
    </div>

    <div class="relative z-10 min-h-screen">
        <!-- Header -->
        <header class="relative bg-white/90 backdrop-blur-sm shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-teal-dark">Finalizar Pedido</h1>
                    <a href="{{ route('cart.index') }}" class="text-gray-700 hover:text-teal-dark transition-colors font-medium">
                        ← Volver al Carrito
                    </a>
                </div>
            </div>
        </header>

        <!-- Contenido -->
        <main class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Formulario -->
                <div class="lg:col-span-2">
                    <div class="bg-white/95 backdrop-blur-sm rounded-lg shadow-xl border-2 border-teal-light p-6">
                        <h2 class="text-xl font-semibold text-teal-dark mb-6">
                            Información de Contacto
                        </h2>

                        <form method="POST" action="{{ route('checkout.store') }}">
                            @csrf

                            <!-- Nombre -->
                            <div class="mb-4">
                                <label for="customer_name" class="block text-sm font-medium text-teal-dark mb-2">
                                    Nombre Completo <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="customer_name"
                                    name="customer_name" 
                                    value="{{ old('customer_name') }}" 
                                    required
                                    class="w-full px-4 py-2 border border-teal-light rounded-md focus:ring-teal-light focus:border-teal-medium"
                                    placeholder="Ej: Juan Pérez"
                                >
                                @error('customer_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Teléfono -->
                            <div class="mb-4">
                                <label for="customer_phone" class="block text-sm font-medium text-teal-dark mb-2">
                                    Teléfono <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="customer_phone"
                                    name="customer_phone" 
                                    value="{{ old('customer_phone') }}" 
                                    required
                                    class="w-full px-4 py-2 border border-teal-light rounded-md focus:ring-teal-light focus:border-teal-medium"
                                    placeholder="Ej: 555-1234-5678"
                                >
                                @error('customer_phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Notas -->
                            <div class="mb-6">
                                <label for="notes" class="block text-sm font-medium text-teal-dark mb-2">
                                    Notas Adicionales (Opcional)
                                </label>
                                <textarea 
                                    id="notes"
                                    name="notes" 
                                    rows="4"
                                    class="w-full px-4 py-2 border border-teal-light rounded-md focus:ring-teal-light focus:border-teal-medium"
                                    placeholder="Instrucciones especiales, dirección de entrega, etc."
                                >{{ old('notes') }}</textarea>
                                @error('notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="w-full bg-teal-gradient hover:opacity-90 text-white font-semibold py-3 px-6 rounded-lg transition-all shadow-md hover:shadow-lg">
                                Confirmar Pedido
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Resumen -->
                <div class="lg:col-span-1">
                    <div class="bg-white/95 backdrop-blur-sm rounded-lg shadow-xl border-2 border-teal-light p-6 sticky top-4">
                        <h2 class="text-xl font-semibold text-teal-dark mb-4">
                            Resumen del Pedido
                        </h2>
                        
                        <div class="space-y-3 mb-4">
                            @foreach($items as $item)
                                <div class="flex justify-between items-start border-b border-teal-pastel pb-3">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $item['product']->name }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            Cantidad: {{ $item['quantity'] }} × ${{ number_format($item['price'], 2) }}
                                        </p>
                                    </div>
                                    <p class="text-sm font-semibold text-teal-dark">
                                        ${{ number_format($item['subtotal'], 2) }}
                                    </p>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t border-teal-pastel pt-4 mt-4">
                            <div class="flex justify-between text-lg font-bold text-teal-dark">
                                <span>Total:</span>
                                <span>${{ number_format($total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
