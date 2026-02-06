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
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Estado del Pedido</h1>
                    <a href="{{ route('menu.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                        Volver al Menú
                    </a>
                </div>
            </div>
        </header>

        <!-- Contenido -->
        <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
                <!-- Número de Pedido -->
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                        Pedido #{{ $order->id }}
                    </h2>
                    <p class="text-gray-500 dark:text-gray-400">
                        Realizado el {{ $order->created_at->format('d/m/Y \a \l\a\s H:i') }}
                    </p>
                </div>

                <!-- Estado -->
                <div class="text-center mb-8">
                    @if($order->status == 'pendiente')
                        <span class="px-4 py-2 inline-flex text-lg font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                            ⏳ Pendiente
                        </span>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">Tu pedido está siendo procesado</p>
                    @elseif($order->status == 'en_preparacion')
                        <span class="px-4 py-2 inline-flex text-lg font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                            👨‍🍳 En Preparación
                        </span>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">Tu pedido está siendo preparado</p>
                    @else
                        <span class="px-4 py-2 inline-flex text-lg font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                            ✅ Entregado
                        </span>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">Tu pedido ha sido entregado</p>
                    @endif
                </div>

                <!-- Información del Cliente -->
                <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Información de Contacto</h3>
                    <p class="text-gray-600 dark:text-gray-400"><strong>Nombre:</strong> {{ $order->customer_name }}</p>
                    <p class="text-gray-600 dark:text-gray-400"><strong>Teléfono:</strong> {{ $order->customer_phone }}</p>
                    @if($order->notes)
                        <p class="text-gray-600 dark:text-gray-400 mt-2"><strong>Notas:</strong> {{ $order->notes }}</p>
                    @endif
                </div>

                <!-- Productos -->
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Productos del Pedido</h3>
                    <div class="space-y-3">
                        @foreach($order->items as $item)
                            <div class="flex items-center space-x-4 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                @if($item->product->image)
                                    <img src="{{ Storage::url($item->product->image) }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 dark:bg-gray-600 rounded flex items-center justify-center">
                                        <span class="text-gray-400 text-xs">Sin imagen</span>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900 dark:text-white">{{ $item->product->name }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Cantidad: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-gray-900 dark:text-white">
                                        ${{ number_format($item->quantity * $item->price, 2) }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Total -->
                <div class="border-t dark:border-gray-700 pt-4">
                    <div class="flex justify-between items-center">
                        <span class="text-xl font-bold text-gray-900 dark:text-white">Total:</span>
                        <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                            ${{ number_format($order->total, 2) }}
                        </span>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>



