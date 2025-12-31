<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800;900&display=swap');
        .font-hatil { font-family: 'Inter', sans-serif; }
        .label-tiny { font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.2em; color: #94a3b8; display: block; margin-bottom: 0.75rem; }
        .input-hatil { width: 100%; background-color: #f8fafc; border: 2px solid #f1f5f9; border-radius: 1.5rem; padding: 1rem 1.5rem; font-size: 13px; font-weight: 700; color: #1e293b; transition: all 0.3s; }
        .input-hatil:focus { outline: none; border-color: #0f172a; background-color: #fff; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); }
        .reveal { animation: fadeInUp 0.6s ease-out forwards; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    </style>

    <x-slot name="header">
        <div class="w-full rounded-b-[4rem] shadow-2xl bg-slate-900">
            <div class="max-w-7xl mx-auto px-6 py-12 reveal">
                <nav class="flex mb-3 text-white/30 text-[10px] font-black uppercase tracking-[0.5em]">
                    <span>TESORERÍA</span> <span class="mx-2">/</span> <span>MODIFICACIÓN</span>
                </nav>
                <h2 class="font-hatil font-black text-4xl text-white tracking-tighter italic uppercase leading-none">
                    Editar <span class="text-white/40">Pago #{{ $pago->Pago_id }}</span>
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen font-hatil">
        <div class="max-w-3xl mx-auto px-6 lg:px-8">
            
            {{-- ALERTAS DE ERROR --}}
            @if ($errors->any())
                <div class="mb-8 p-6 bg-red-50 border-l-4 border-red-500 rounded-2xl reveal">
                    <h3 class="text-xs font-black text-red-800 uppercase tracking-widest">Errores detectados</h3>
                    <ul class="mt-2 text-xs text-red-700 font-bold list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white p-12 rounded-[4rem] shadow-sm border border-slate-100 reveal">
                <form action="{{ route('admin.pagos.update', $pago->Pago_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-8">
                        {{-- PEDIDO ASOCIADO --}}
                        <div>
                            <span class="label-tiny">Pedido Vinculado</span>
                            <select name="Pedido_id" id="Pedido_id" class="input-hatil" required>
                                @foreach ($pedidos as $pedido)
                                    <option value="{{ $pedido->Pedido_id }}" 
                                        {{ old('Pedido_id', $pago->Pedido_id) == $pedido->Pedido_id ? 'selected' : '' }}>
                                        ORDEN #{{ $pedido->Pedido_id }} — {{ $pedido->usuario->name ?? 'Cliente' }} (Bs {{ number_format($pedido->Total, 2) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            {{-- MONTO --}}
                            <div>
                                <span class="label-tiny">Monto (Bs)</span>
                                <input type="number" name="Monto" step="0.01" value="{{ old('Monto', $pago->Monto) }}" class="input-hatil" required>
                            </div>

                            {{-- MÉTODO DE PAGO --}}
                            <div>
                                <span class="label-tiny">Método de Pago</span>
                                <select name="Metodo_Pago" class="input-hatil" required>
                                    @foreach ($metodos as $metodo)
                                        <option value="{{ $metodo }}" {{ old('Metodo_Pago', $pago->Metodo_Pago) == $metodo ? 'selected' : '' }}>
                                            {{ $metodo }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            {{-- FECHA --}}
                            <div>
                                <span class="label-tiny">Fecha de Operación</span>
                                {{-- Usamos format('Y-m-d') para el input tipo date --}}
                                <input type="date" name="Fecha_Pago" 
                                    value="{{ old('Fecha_Pago', \Carbon\Carbon::parse($pago->Fecha_pago)->format('Y-m-d')) }}" 
                                    class="input-hatil" required>
                            </div>

                            {{-- ESTADO --}}
                            <div>
                                <span class="label-tiny">Estado de Transacción</span>
                                <select name="Estado_Pago" class="input-hatil" required>
                                    @foreach ($estados as $estado)
                                        <option value="{{ $estado }}" {{ old('Estado_Pago', $pago->Estado) == $estado ? 'selected' : '' }}>
                                            {{ $estado }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- BOTONES --}}
                    <div class="mt-12 pt-8 border-t border-slate-50 flex items-center justify-between">
                        <a href="{{ route('admin.pagos.index') }}" class="text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-slate-900 transition-all italic">
                            ← Cancelar
                        </a>
                        <button type="submit" class="bg-slate-900 text-white px-12 py-5 rounded-[2rem] text-[10px] font-black uppercase tracking-[0.3em] shadow-2xl hover:bg-slate-800 transition-all italic">
                            Actualizar Registro
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>