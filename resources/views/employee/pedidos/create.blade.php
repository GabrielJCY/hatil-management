<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nuevo Pedido') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                
                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('admin.pedidos.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        {{-- CLIENTE --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cliente</label>
                            <select name="UsuarioC_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="">Seleccione un cliente</option>
                                @foreach($clientes as $cliente)
                                    {{-- CORRECCIÓN: El campo en la tabla 'users' es 'name', no 'nombre' --}}
                                    <option value="{{ $cliente->id }}" {{ old('UsuarioC_id') == $cliente->id ? 'selected' : '' }}>
                                        {{ $cliente->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- EMPLEADO (AUTO) --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Atendido por:</label>
                            <input type="text" value="{{ auth()->user()->name }}" class="mt-1 block w-full rounded-md border-gray-200 bg-gray-50 text-gray-500 cursor-not-allowed" readonly>
                        </div>

                        {{-- PAGO --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Método de Pago</label>
                            <select name="Metodo_pago" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="Efectivo" {{ old('Metodo_pago') == 'Efectivo' ? 'selected' : '' }}>Efectivo</option>
                                <option value="Transferencia" {{ old('Metodo_pago') == 'Transferencia' ? 'selected' : '' }}>Transferencia</option>
                                <option value="Tarjeta" {{ old('Metodo_pago') == 'Tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                            </select>
                        </div>

                        {{-- DIRECCIÓN --}}
                        <div class="md:col-span-3">
                            <label class="block text-sm font-medium text-gray-700">Dirección de Envío (Máx. 100 caracteres)</label>
                            <input type="text" name="Direccion_envio" maxlength="100" value="{{ old('Direccion_envio') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                    </div>

                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-200 mb-6">
                        <h3 class="text-sm font-bold text-blue-800 mb-3">Agregar Muebles al Detalle</h3>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                            <div class="md:col-span-2">
                                <select id="mueble_selector" class="block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="">Seleccionar mueble...</option>
                                    @foreach($muebles as $mueble)
                                        {{-- CORRECCIÓN: Usamos Mueble_id para el value --}}
                                        <option value="{{ $mueble->Mueble_id }}" data-precio="{{ $mueble->Precio }}" data-nombre="{{ $mueble->Nombre }}">
                                            {{ $mueble->Nombre }} - ${{ number_format($mueble->Precio, 2) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <input type="number" id="cantidad_selector" value="1" min="1" class="block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <button type="button" onclick="addItem()" class="bg-blue-600 text-white px-4 py-2 rounded-md font-bold hover:bg-blue-700">
                                + Agregar
                            </button>
                        </div>
                    </div>

                    <div class="mb-6 overflow-x-auto">
                        <table class="min-w-full border" id="detail_table">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase">Producto</th>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase">P. Unitario</th>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase">Cant.</th>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase">Subtotal</th>
                                    <th class="px-4 py-2 text-center text-xs font-bold text-gray-500 uppercase">Borrar</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200"></tbody>
                            <tfoot class="bg-gray-100 font-bold">
                                <tr>
                                    <td colspan="3" class="px-4 py-2 text-right">TOTAL PEDIDO:</td>
                                    <td colspan="2" class="px-4 py-2 text-blue-600" id="total_display">$0.00</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('admin.pedidos.index') }}" class="px-4 py-2 text-gray-600">Cancelar</a>
                        <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-md font-bold hover:bg-green-700">
                            Confirmar y Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let counter = 0;
        function addItem() {
            const sel = document.getElementById('mueble_selector');
            const qty = document.getElementById('cantidad_selector');
            const opt = sel.options[sel.selectedIndex];

            if(!opt.value || qty.value < 1) return;

            const sub = parseFloat(opt.dataset.precio) * parseInt(qty.value);
            const tbody = document.querySelector('#detail_table tbody');
            const row = document.createElement('tr');
            row.id = `row-${counter}`;
            row.className = "hover:bg-gray-50"; // Mejora visual
            row.innerHTML = `
                <td class="px-4 py-2 text-sm">${opt.dataset.nombre}<input type="hidden" name="muebles[${counter}][Mueble_id]" value="${opt.value}"></td>
                <td class="px-4 py-2 text-sm">$${parseFloat(opt.dataset.precio).toFixed(2)}</td>
                <td class="px-4 py-2 text-sm">${qty.value}<input type="hidden" name="muebles[${counter}][Cantidad]" value="${qty.value}"></td>
                <td class="px-4 py-2 text-sm font-bold sub-val">$${sub.toFixed(2)}</td>
                <td class="px-4 py-2 text-center">
                    <button type="button" onclick="this.closest('tr').remove(); updateTot();" class="text-red-500 hover:text-red-700 font-bold">✖</button>
                </td>
            `;
            tbody.appendChild(row);
            counter++;
            updateTot();
            
            // Limpiar selector después de agregar
            sel.value = "";
            qty.value = 1;
        }

        function updateTot() {
            let t = 0;
            document.querySelectorAll('.sub-val').forEach(v => {
                t += parseFloat(v.innerText.replace('$', ''));
            });
            document.getElementById('total_display').innerText = `$${t.toFixed(2)}`;
        }
    </script>
</x-app-layout>