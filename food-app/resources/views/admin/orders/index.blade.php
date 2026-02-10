@php
use Illuminate\Support\Facades\Storage;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Gestión de Pedidos') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Búsqueda y Filtros -->
            <div class="bg-white rounded-lg shadow-md border-2 border-teal-light p-4 mb-6">
                <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Buscar por nombre de cliente o teléfono..." 
                            class="w-full px-4 py-2 border border-teal-light rounded-md focus:ring-teal-light focus:border-teal-medium"
                        >
                    </div>
                    <div class="flex gap-2">
                        <select 
                            name="status" 
                            class="px-4 py-2 border border-teal-light rounded-md focus:ring-teal-light focus:border-teal-medium"
                        >
                            <option value="">Todos los estados</option>
                            <option value="pendiente" {{ request('status') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="en_preparacion" {{ request('status') == 'en_preparacion' ? 'selected' : '' }}>En Preparación</option>
                            <option value="entregado" {{ request('status') == 'entregado' ? 'selected' : '' }}>Entregado</option>
                        </select>
                        <button type="submit" class="px-4 py-2 bg-teal-gradient text-white rounded-md hover:opacity-90 transition-opacity">
                            Buscar
                        </button>
                        @if(request('search') || request('status'))
                            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors">
                                Limpiar
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-2 border-teal-light">
                <div class="p-6 text-gray-900">
                    @if($orders->count() > 0)
                        <div class="overflow-x-auto -mx-6 sm:mx-0">
                            <table class="min-w-full divide-y divide-teal-pastel">
                                <thead class="bg-teal-pastel">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-dark uppercase tracking-wider">
                                            ID
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-dark uppercase tracking-wider">
                                            Cliente
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-dark uppercase tracking-wider">
                                            Teléfono
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-dark uppercase tracking-wider">
                                            Total
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-dark uppercase tracking-wider">
                                            Estado
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-dark uppercase tracking-wider">
                                            Fecha
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-dark uppercase tracking-wider">
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-teal-pastel">
                                    @foreach($orders as $order)
                                        <tr class="hover:bg-teal-pastel transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    #{{ $order->id }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ $order->customer_name }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500">
                                                    {{ $order->customer_phone }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-teal-dark">
                                                    ${{ number_format($order->total, 2) }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($order->status == 'pendiente')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        Pendiente
                                                    </span>
                                                @elseif($order->status == 'en_preparacion')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                        En Preparación
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Entregado
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500">
                                                    {{ $order->created_at->format('d/m/Y H:i') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('admin.orders.show', $order) }}" class="text-teal-dark hover:text-teal-medium font-medium">
                                                    Ver Detalle
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4 flex justify-center">
                            {{ $orders->links('vendor.pagination.tailwind') }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500 dark:text-gray-400">No hay pedidos registrados.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>



