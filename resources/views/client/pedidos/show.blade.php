@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">Detalle del Pedido #{{ $pedido->id }}</h1>

    <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
        <p><strong>Fecha:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Estado:</strong> <span class="px-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">{{ $pedido->estado }}</span></p>
        <p><strong>Total Pagado:</strong> ${{ number_format($pedido->total, 2) }}</p>
        {{-- Puedes añadir aquí la dirección de envío --}}
        
        <a href="{{ route('cliente.misPedidos') }}" class="mt-4 inline-block text-sm text-gray-600 hover:text-gray-900">
            &larr; Volver a Mis Pedidos
        </a>
    </div>

    <h2 class="text-2xl font-semibold mb-4">Productos</h2>
    <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio Unitario</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($pedido->detalles as $detalle)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $detalle->mueble->nombre }} {{-- Asumiendo una relación $detalle->mueble --}}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $detalle->cantidad }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            ${{ number_format($detalle->precio_unitario, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                            ${{ number_format($detalle->cantidad * $detalle->precio_unitario, 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection