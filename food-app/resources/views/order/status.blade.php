@php
use Illuminate\Support\Facades\Storage;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Estado del Pedido #{{ $order->id }} - {{ config('app.name', 'Laravel') }}</title>
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
        .font-dancing {
            font-family: 'Dancing Script', cursive;
        }
        .bg-teal-gradient {
            background: linear-gradient(135deg, var(--teal-dark) 0%, var(--teal-medium) 50%, var(--teal-light) 100%);
        }
        .text-teal-dark { color: var(--teal-dark); }
        .bg-teal-pastel { background-color: var(--teal-pastel); }
        .border-teal-light { border-color: var(--teal-light); }
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
                    <h1 class="text-2xl font-bold text-teal-dark">Estado del Pedido</h1>
                    <a href="{{ route('menu.index') }}" class="text-gray-700 hover:text-teal-dark transition-colors font-medium">
                        Volver al Menú
                    </a>
                </div>
            </div>
        </header>

        <!-- Contenido -->
        <main class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @if (session('success'))
                <x-alert type="success">{{ session('success') }}</x-alert>
            @endif

            <div class="bg-white/95 backdrop-blur-sm rounded-lg shadow-xl border-2 border-teal-light p-8">
                <!-- Número de Pedido -->
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-teal-dark mb-2">
                        Pedido #{{ $order->id }}
                    </h2>
                    <p class="text-gray-500">
                        Realizado el {{ $order->created_at->format('d/m/Y \a \l\a\s H:i') }}
                    </p>
                </div>

                <!-- Estado -->
                <div class="text-center mb-8">
                    @if($order->status == 'pendiente')
                        <span class="px-4 py-2 inline-flex text-lg font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            ⏳ Pendiente
                        </span>
                        <p class="mt-2 text-gray-600">Tu pedido está siendo procesado</p>
                    @elseif($order->status == 'en_preparacion')
                        <span class="px-4 py-2 inline-flex text-lg font-semibold rounded-full bg-blue-100 text-blue-800">
                            👨‍🍳 En Preparación
                        </span>
                        <p class="mt-2 text-gray-600">Tu pedido está siendo preparado</p>
                    @else
                        <span class="px-4 py-2 inline-flex text-lg font-semibold rounded-full bg-green-100 text-green-800">
                            ✅ Entregado
                        </span>
                        <p class="mt-2 text-gray-600">Tu pedido ha sido entregado</p>
                    @endif
                </div>

                <!-- Información del Cliente -->
                <div class="mb-6 p-4 bg-teal-pastel rounded-lg border border-teal-light">
                    <h3 class="font-semibold text-teal-dark mb-2">Información de Contacto</h3>
                    <p class="text-gray-700"><strong>Nombre:</strong> {{ $order->customer_name }}</p>
                    <p class="text-gray-700"><strong>Teléfono:</strong> {{ $order->customer_phone }}</p>
                    @if($order->notes)
                        <p class="text-gray-700 mt-2"><strong>Notas:</strong> {{ $order->notes }}</p>
                    @endif
                </div>

                <!-- Productos -->
                <div class="mb-6">
                    <h3 class="font-semibold text-teal-dark mb-4">Productos del Pedido</h3>
                    <div class="space-y-3">
                        @foreach($order->items as $item)
                            <div class="flex items-center space-x-4 p-3 bg-teal-pastel rounded-lg border border-teal-light">
                                @if($item->product->image)
                                    <img src="{{ Storage::url($item->product->image) }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-contain rounded bg-white p-1">
                                @else
                                    <div class="w-16 h-16 bg-white rounded flex items-center justify-center border border-teal-light">
                                        <span class="text-teal-medium text-xs">Sin imagen</span>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900">{{ $item->product->name }}</h4>
                                    <p class="text-sm text-gray-600">
                                        Cantidad: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-teal-dark">
                                        ${{ number_format($item->quantity * $item->price, 2) }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Total -->
                <div class="border-t border-teal-light pt-4">
                    <div class="flex justify-between items-center">
                        <span class="text-xl font-bold text-teal-dark">Total:</span>
                        <span class="text-2xl font-bold text-teal-dark">
                            ${{ number_format($order->total, 2) }}
                        </span>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
