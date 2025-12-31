<x-app-layout>
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-8">
            <i class="fas fa-money-check-alt text-green-600 mr-3"></i> Checkout y Dirección
        </h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Columna 1: Formulario de Dirección y Pago (2/3 de ancho) --}}
            <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-3">Información de Envío y Pago</h2>

                {{-- CORREGIDO: 'cliente' por 'client' para coincidir con web.php --}}
                <form method="POST" action="{{ route('client.checkout.store') }}">
                    @csrf
                    
                    {{-- 1. Nombre del Cliente (Editable) --}}
                    <div class="mb-4">
                        <x-input-label for="nombre_cliente" value="Nombre del Cliente" />
                        <x-text-input id="nombre_cliente" name="nombre_cliente" type="text" 
                                      class="mt-1 block w-full bg-gray-100" 
                                      value="{{ old('nombre_cliente', $user->name) }}" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('nombre_cliente')" />
                    </div>

                    {{-- 2. Dirección de Envío --}}
                    <div class="mb-6">
                        <x-input-label for="direccion_envio" value="Dirección de Envío Completa" />
                        <textarea id="direccion_envio" name="direccion_envio" rows="3" 
                                  class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                  placeholder="Ej: Calle Aroma #123, entre Oquendo y Potosí"
                                  required>{{ old('direccion_envio') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('direccion_envio')" />
                    </div>

                    {{-- 3. Método de Pago --}}
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-t pt-4">Selecciona Método de Pago</h3>
                    <div class="space-y-3">
                        @foreach (['Transferencia Bancaria', 'Tarjeta de Crédito', 'Efectivo'] as $method)
                            <label for="metodo_{{ Str::slug($method) }}" class="flex items-center cursor-pointer p-2 hover:bg-gray-50 rounded-lg">
                                <input id="metodo_{{ Str::slug($method) }}" name="metodo_pago" type="radio" value="{{ $method }}" 
                                       class="text-indigo-600 border-gray-300 focus:ring-indigo-500" {{ old('metodo_pago') == $method ? 'checked' : '' }} required>
                                <span class="ml-3 text-gray-700 font-medium">{{ $method }}</span>
                            </label>
                        @endforeach
                        <x-input-error class="mt-2" :messages="$errors->get('metodo_pago')" />
                    </div>

                    {{-- Botón de Confirmación --}}
                    <div class="mt-10">
                        <button type="submit" 
                                class="w-full flex justify-center py-4 px-4 border border-transparent rounded-xl shadow-lg text-xl font-bold text-white bg-green-600 hover:bg-green-700 focus:outline-none transition duration-150 transform hover:scale-[1.01]">
                            Confirmar Pedido y Pagar {{ number_format($carrito['total_general'], 2) }} Bs
                        </button>
                    </div>
                </form>
            </div>

            {{-- Columna 2: Resumen de la Orden (1/3 de ancho) --}}
            <div class="lg:col-span-1 bg-gray-50 rounded-xl shadow-inner p-6 h-fit sticky top-6 border border-gray-200">
                <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-3">Resumen de Compra</h2>
                
                {{-- Lista de Items --}}
                <div class="max-h-60 overflow-y-auto mb-4">
                    @foreach ($carrito['items'] as $item)
                        <div class="flex justify-between text-sm text-gray-600 border-b border-dashed py-2">
                            <span class="font-medium text-gray-800">{{ $item['cantidad'] }}x</span>
                            <span class="flex-1 ml-2">{{ Str::limit($item['mueble']->Nombre, 25) }}</span>
                            <span class="font-semibold text-gray-900 ml-2">{{ number_format($item['subtotal'], 2) }} Bs</span>
                        </div>
                    @endforeach
                </div>

                <div class="space-y-3 mt-4">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal:</span>
                        <span>{{ number_format($carrito['subtotal_general'], 2) }} Bs</span>
                    </div>
                    
                    <div class="flex justify-between text-gray-600">
                        <span>Costo de Envío:</span>
                        <span class="text-green-600 font-medium">{{ $carrito['envio'] > 0 ? number_format($carrito['envio'], 2) . ' Bs' : 'Gratis' }}</span> 
                    </div>

                    <div class="flex justify-between text-2xl font-black text-indigo-700 border-t-2 border-indigo-100 pt-4">
                        <span>TOTAL:</span>
                        <span>{{ number_format($carrito['total_general'], 2) }} Bs</span>
                    </div>
                </div>

                <div class="mt-6 text-center">
                    <a href="{{ route('client.carrito.index') }}" class="text-sm text-indigo-600 hover:underline">
                        <i class="fas fa-edit mr-1"></i> Modificar carrito
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>