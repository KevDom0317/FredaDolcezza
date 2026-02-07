@php
use Illuminate\Support\Facades\Storage;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Gestión de Productos') }}
            </h2>
            <a href="{{ route('admin.products.create') }}">
                <x-primary-button>
                    {{ __('Nuevo Producto') }}
                </x-primary-button>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-2 border-teal-light">
                <div class="p-6 text-gray-900">
                    @if($products->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-teal-pastel">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-dark uppercase tracking-wider">
                                            Imagen
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-dark uppercase tracking-wider">
                                            Nombre
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-dark uppercase tracking-wider">
                                            Categoría
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-dark uppercase tracking-wider">
                                            Precio
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-dark uppercase tracking-wider">
                                            Estado
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-dark uppercase tracking-wider">
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-teal-pastel">
                                    @foreach($products as $product)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($product->image)
                                                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="h-16 w-16 object-cover rounded">
                                                @else
                                                    <div class="h-16 w-16 bg-teal-pastel rounded flex items-center justify-center">
                                                        <span class="text-teal-medium text-xs">Sin imagen</span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $product->name }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ Str::limit($product->description, 40) }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ $product->category->name }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-teal-dark">
                                                    ${{ number_format($product->price, 2) }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($product->is_available)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Disponible
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        No disponible
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('admin.products.edit', $product) }}" class="text-teal-dark hover:text-teal-medium font-medium">
                                                        Editar
                                                    </a>
                                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este producto?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-800 transition-colors">
                                                            Eliminar
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $products->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500 mb-4">No hay productos registrados.</p>
                            <a href="{{ route('admin.products.create') }}">
                                <x-primary-button>
                                    {{ __('Crear Primer Producto') }}
                                </x-primary-button>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>



