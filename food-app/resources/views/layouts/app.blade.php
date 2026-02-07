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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            :root {
                --teal-dark: #345b63;
                --teal-medium: #4a7c8a;
                --teal-light: #7fb3c3;
                --teal-pastel: #b8d4dc;
            }
            .bg-teal-dark { background-color: var(--teal-dark); }
            .bg-teal-medium { background-color: var(--teal-medium); }
            .bg-teal-light { background-color: var(--teal-light); }
            .bg-teal-gradient {
                background: linear-gradient(135deg, var(--teal-dark) 0%, var(--teal-medium) 50%, var(--teal-light) 100%);
            }
            .text-teal-dark { color: var(--teal-dark); }
            .text-teal-medium { color: var(--teal-medium); }
            .border-teal-dark { border-color: var(--teal-dark); }
            .hover\:bg-teal-dark:hover { background-color: var(--teal-dark); }
            .hover\:bg-teal-medium:hover { background-color: var(--teal-medium); }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-50" style="background: linear-gradient(135deg, #f0f9fa 0%, #e8f4f6 100%);">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-teal-gradient shadow-md">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <div class="text-white">
                            {{ $header }}
                        </div>
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
