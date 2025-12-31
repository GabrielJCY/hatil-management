<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Pedidos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="container mx-auto p-4">
                    <h1 class="text-3xl font-bold mb-6">📦 Mis Pedidos</h1>

                    {{-- Verifica si hay pedidos para mostrar --}}
                    @if($pedidos->isEmpty())
                        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
                            <p class="font-bold">Aún no tienes pedidos.</p>
                            <p>¡Visita nuestro catálogo para hacer tu primera compra!</p>
                            <a href="{{ route('cliente.catalogo.index') }}" class="text-yellow-800 underline">Ir al Catálogo</a>
                        </div>
                    @else
                        <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"># Pedido</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($pedidos as $pedido)
                                        <tr>
                                            {{-- ID del Pedido (Número de referencia) --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $pedido->id }}
                                            </td>
                                            
                                            {{-- Fecha del Pedido --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $pedido->created_at->format('d/m/Y') }}
                                            </td>
                                            
                                            {{-- Total del Pedido --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-semibold">
                                                ${{ number_format($pedido->total, 2) }}
                                            </td>
                                            
                                            {{-- Estado del Pedido --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    {{ $pedido->estado ?? 'Pendiente' }}
                                                </span>
                                            </td>
                                            
                                            {{-- Acciones (CORREGIDO el enlace a la ruta de detalle) --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('cliente.pedidos.show', $pedido->id) }}" class="text-indigo-600 hover:text-indigo-900">Ver Detalles</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>