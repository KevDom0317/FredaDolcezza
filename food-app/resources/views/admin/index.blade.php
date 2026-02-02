<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Panel de Administración') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold mb-4">Bienvenido al Panel de Administración</h1>
                    <p class="mb-4">Desde aquí podrás gestionar productos, categorías y pedidos.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                        <div class="bg-blue-100 dark:bg-blue-900 p-4 rounded-lg">
                            <h3 class="font-semibold text-lg mb-2">Productos</h3>
                            <p class="text-sm">Gestiona tu menú de productos</p>
                        </div>
                        <div class="bg-green-100 dark:bg-green-900 p-4 rounded-lg">
                            <h3 class="font-semibold text-lg mb-2">Categorías</h3>
                            <p class="text-sm">Organiza tus productos por categorías</p>
                        </div>
                        <div class="bg-yellow-100 dark:bg-yellow-900 p-4 rounded-lg">
                            <h3 class="font-semibold text-lg mb-2">Pedidos</h3>
                            <p class="text-sm">Revisa y gestiona los pedidos</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

