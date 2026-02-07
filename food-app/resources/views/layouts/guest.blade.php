<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
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
            .bg-teal-dark { background-color: var(--teal-dark); }
            .bg-teal-medium { background-color: var(--teal-medium); }
            .bg-teal-light { background-color: var(--teal-light); }
            .bg-teal-pastel { background-color: var(--teal-pastel); }
            .text-teal-dark { color: var(--teal-dark); }
            .text-teal-medium { color: var(--teal-medium); }
            .border-teal-dark { border-color: var(--teal-dark); }
            .border-teal-medium { border-color: var(--teal-medium); }
            .border-teal-light { border-color: var(--teal-light); }
            .focus\:ring-teal:focus { --tw-ring-color: var(--teal-light); }
            .focus\:border-teal:focus { border-color: var(--teal-light); }
        </style>
    </head>
    <body class="font-sans antialiased">
        <!-- Fondo con gradiente -->
        <div class="fixed inset-0 z-0 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-[#b8d4dc] via-[#7fb3c3] to-[#4a7c8a] opacity-60"></div>
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjQwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZGVmcz48cGF0dGVybiBpZD0iYSIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIj48Y2lyY2xlIGN4PSIyMCIgY3k9IjIwIiByPSIyIiBmaWxsPSIjMzQ1YjYzIiBmaWxsLW9wYWNpdHk9IjAuMSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0idXJsKCNhKSIvPjwvc3ZnPg==')] opacity-20"></div>
        </div>

        <div class="relative z-10 min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <!-- Logo -->
            <div class="mb-6">
                <a href="{{ route('menu.index') }}" class="flex items-center space-x-3">
                    <div class="w-16 h-16 bg-teal-gradient rounded-full flex items-center justify-center shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h1 class="font-dancing text-4xl font-bold text-teal-dark">
                        {{ config('app.name', 'Freda Dolcezza') }}
                    </h1>
                </a>
            </div>

            <!-- Formulario -->
            <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white/95 backdrop-blur-sm shadow-xl border-2 border-teal-light overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>

            <!-- Link de regreso -->
            <div class="mt-6">
                <a href="{{ route('menu.index') }}" class="text-teal-dark hover:text-teal-medium text-sm font-medium transition-colors">
                    ← Volver al inicio
                </a>
            </div>
        </div>
    </body>
</html>
