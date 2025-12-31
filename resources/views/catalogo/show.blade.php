<x-app-layout>
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-8">
            <i class="fas fa-shopping-cart text-indigo-600 mr-3"></i>Tu Carrito de Compras
        </h1>

        @if (empty($carrito) || count($carrito['items']) === 0)
            {{-- Mensaje si el carrito está vacío --}}
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg" role="alert">
                <p class="font-bold">Carrito Vacío</p>
                {{-- CORREGIDO: cliente -> client --}}
                <p>Aún no has añadido ningún mueble. ¡Explora nuestro <a href="{{ route('client.catalogo.index') }}" class="font-semibold underline">catálogo</a>!</p>
            </div>
        @else
            {{-- Contenido del Carrito (Dividido en Tabla de Ítems y Resumen) --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- Columna 1: Productos en el Carrito (2/3 de ancho) --}}
                <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-3">Productos Seleccionados</h2>

                    @foreach ($carrito['items'] as $item)
                        <div class="flex items-center border-b border-gray-100 py-4">
                            
                            {{-- Imagen corregida para usar storage --}}
                            <div class="w-20 h-20 flex-shrink-0 overflow-hidden rounded-md border border-gray-200 mr-4">
                                <img src="{{ $item['mueble']->Imagen ? asset('storage/' . $item['mueble']->Imagen) : 'https://via.placeholder.com/80x80?text=Mueble' }}" 
                                     alt="{{ $item['mueble']->Nombre }}" 
                                     class="h-full w-full object-cover object-center">
                            </div>

                            {{-- Nombre y Precio Unitario --}}
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-medium text-gray-900">
                                    {{-- CORREGIDO: cliente -> client --}}
                                    <a href="{{ route('client.muebles.show', $item['mueble']->Mueble_id) }}" class="hover:text-indigo-600">
                                        {{ $item['mueble']->Nombre }}
                                    </a>
                                </h3>
                                <p class="text-sm text-gray-500">Precio unitario: {{ number_format($item['mueble']->Precio, 2) }} Bs</p>
                            </div>

                            {{-- Formulario de Cantidad y Subtotal --}}
                            <div class="ml-4 flex-shrink-0 flex items-center space-x-4">
                                
                                {{-- Formulario para Actualizar Cantidad --}}
                                {{-- CORREGIDO: cliente -> client --}}
                                <form action="{{ route('client.carrito.update', $item['mueble']->Mueble_id) }}" method="POST" class="flex items-center space-x-2">
                                    @csrf
                                    @method('PATCH') 
                                    
                                    <label for="quantity-{{ $item['mueble']->Mueble_id }}" class="sr-only">Cantidad</label>
                                    <input type="number" name="cantidad" id="quantity-{{ $item['mueble']->Mueble_id }}" 
                                           value="{{ $item['cantidad'] }}" min="1" 
                                           onchange="this.form.submit()" 
                                           class="w-16 rounded-md border border-gray-300 text-center py-1 text-sm">
                                </form>

                                {{-- Subtotal --}}
                                <p class="text-lg font-semibold text-gray-900 w-24 text-right">
                                    {{ number_format($item['subtotal'], 2) }} Bs
                                </p>
                                
                                {{-- Botón para Remover --}}
                                {{-- CORREGIDO: cliente -> client --}}
                                <form action="{{ route('client.carrito.remove', $item['mueble']->Mueble_id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-600 transition duration-150">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Columna 2: Resumen de la Orden (1/3 de ancho) --}}
                <div class="lg:col-span-1 bg-white rounded-xl shadow-2xl p-6 h-fit sticky top-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-3">Resumen de la Orden</h2>

                    <div class="space-y-4">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal:</span>
                            <span>{{ number_format($carrito['subtotal_general'], 2) }} Bs</span>
                        </div>
                        
                        <div class="flex justify-between text-gray-600 border-t pt-4">
                            <span>Envío estimado:</span>
                            <span>{{ number_format($carrito['envio'] ?? 0, 2) }} Bs</span> 
                        </div>

                        <div class="flex justify-between text-2xl font-bold text-gray-900 border-t pt-4">
                            <span>Total:</span>
                            <span>{{ number_format($carrito['total_general'], 2) }} Bs</span>
                        </div>
                    </div>

                    {{-- Botón CTA (Call to Action) Checkout --}}
                    <div class="mt-8">
                        {{-- CORREGIDO: cliente.checkout -> client.checkout --}}
                        <a href="{{ route('client.checkout') }}" 
                           class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-lg text-lg font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none transition duration-150">
                            Proceder a Pagar <i class="fas fa-arrow-right ml-2 mt-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>