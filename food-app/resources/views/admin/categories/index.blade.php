@php
use Illuminate\Support\Facades\Storage;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Gestión de Categorías') }}
            </h2>
            <a href="{{ route('admin.categories.create') }}">
                <x-primary-button>
                    {{ __('Nueva Categoría') }}
                </x-primary-button>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Búsqueda y Filtros -->
            <div class="bg-white rounded-lg shadow-md border-2 border-teal-light p-4 mb-6">
                <form method="GET" action="{{ route('admin.categories.index') }}" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Buscar por nombre o descripción..." 
                            class="w-full px-4 py-2 border border-teal-light rounded-md focus:ring-teal-light focus:border-teal-medium"
                        >
                    </div>
                    <div class="flex gap-2">
                        <select 
                            name="status" 
                            class="px-4 py-2 border border-teal-light rounded-md focus:ring-teal-light focus:border-teal-medium"
                        >
                            <option value="">Todos los estados</option>
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Activa</option>
                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactiva</option>
                        </select>
                        <button type="submit" class="px-4 py-2 bg-teal-gradient text-white rounded-md hover:opacity-90 transition-opacity">
                            Buscar
                        </button>
                        @if(request('search') || request('status'))
                            <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors">
                                Limpiar
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-2 border-teal-light">
                <div class="p-6 text-gray-900">
                    @if($categories->count() > 0)
                        <div class="overflow-x-auto -mx-6 sm:mx-0">
                            <table class="min-w-full divide-y divide-teal-pastel">
                                <thead class="bg-teal-pastel">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-dark uppercase tracking-wider">
                                            Imagen
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-dark uppercase tracking-wider">
                                            Nombre
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-dark uppercase tracking-wider">
                                            Descripción
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
                                    @foreach($categories as $category)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($category->image)
                                                    <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="h-16 w-16 object-cover rounded">
                                                @else
                                                    <div class="h-16 w-16 bg-teal-pastel rounded flex items-center justify-center">
                                                        <span class="text-teal-medium text-xs">Sin imagen</span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $category->name }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-500">
                                                    {{ Str::limit($category->description, 50) }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($category->is_active)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Activa
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        Inactiva
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('admin.categories.edit', $category) }}" class="text-teal-dark hover:text-teal-medium font-medium">
                                                        Editar
                                                    </a>
                                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
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
                        <div class="mt-4 flex justify-center">
                            {{ $categories->links('vendor.pagination.tailwind') }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500 dark:text-gray-400 mb-4">No hay categorías registradas.</p>
                            <a href="{{ route('admin.categories.create') }}">
                                <x-primary-button>
                                    {{ __('Crear Primera Categoría') }}
                                </x-primary-button>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

