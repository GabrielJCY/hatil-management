<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800;900&display=swap');
        :root { --dynamic-theme: #0f172a; }
        .font-hatil { font-family: 'Inter', sans-serif; }
        
        .label-tiny {
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: #94a3b8;
            margin-bottom: 0.75rem;
            display: block;
        }

        .input-hatil {
            width: 100%;
            background-color: #f8fafc;
            border: 2px solid #f1f5f9;
            border-radius: 1.5rem;
            padding: 1rem 1.5rem;
            font-size: 13px;
            font-weight: 700;
            color: #1e293b;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .input-hatil:focus {
            outline: none;
            border-color: var(--dynamic-theme);
            background-color: #ffffff;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        }

        .reveal { animation: fadeInUp 0.6s ease-out forwards; }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    <x-slot name="header">
        <div id="system-header-bg" class="w-full transition-all duration-500 rounded-b-[4rem] shadow-2xl bg-slate-900">
            <div class="max-w-7xl mx-auto px-6 py-12">
                <div class="reveal flex justify-between items-end">
                    <div>
                        <nav class="flex mb-3 text-white/30 text-[10px] font-black uppercase tracking-[0.5em]">
                            <span>ADMINISTRACIÓN</span> <span class="mx-2">/</span> <span>TESORERÍA</span>
                        </nav>
                        <h2 class="font-hatil font-black text-4xl text-white tracking-tighter italic uppercase leading-none">
                            Registrar <span class="text-white/40">Nuevo Pago</span>
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div id="main-wrapper" class="py-12 min-h-screen font-hatil bg-slate-50">
        <div class="max-w-3xl mx-auto px-6 lg:px-8">
            
            @if ($errors->any())
                <div class="mb-8 p-6 bg-red-50 border-l-4 border-red-500 rounded-2xl reveal">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-xs font-black text-red-800 uppercase tracking-widest">Se detectaron errores</h3>
                            <ul class="mt-2 text-xs text-red-700 font-bold list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white p-12 rounded-[4rem] shadow-sm border border-slate-100 reveal">
                <form action="{{ route('admin.pagos.store') }}" method="POST">
                    @csrf

                    <div class="space-y-8">
                        {{-- SELECCIÓN DE PEDIDO --}}
                        <div>
                            <span class="label-tiny">Pedido Asociado</span>
                            <select name="Pedido_id" id="Pedido_id" onchange="autocompletar()" class="input-hatil" required>
                                <option value="">-- Seleccione un Pedido --</option>
                                @foreach ($pedidos as $pedido)
                                    <option value="{{ $pedido->Pedido_id }}" 
                                            data-total="{{ $pedido->Total }}"
                                            data-metodo="{{ $pedido->Metodo_pago }}"
                                            {{ old('Pedido_id') == $pedido->Pedido_id ? 'selected' : '' }}>
                                        ORDEN #{{ $pedido->Pedido_id }} — ({{ $pedido->cliente->name ?? 'N/A' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            {{-- MONTO --}}
                            <div>
                                <span class="label-tiny">Monto a Recibir (Bs)</span>
                                <input type="number" name="Monto" id="Monto" step="0.01" min="0" 
                                       value="{{ old('Monto') }}" class="input-hatil" required>
                            </div>

                            {{-- MÉTODO DE PAGO --}}
                            <div>
                                <span class="label-tiny">Método de Pago</span>
                                <select name="Metodo_Pago" id="Metodo_Pago" class="input-hatil" required>
                                    @foreach ($metodos as $metodo)
                                        <option value="{{ $metodo }}" {{ old('Metodo_Pago') == $metodo ? 'selected' : '' }}>
                                            {{ $metodo }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            {{-- FECHA --}}
                            <div>
                                <span class="label-tiny">Fecha y Hora</span>
                                <input type="datetime-local" name="Fecha_Pago" id="Fecha_Pago" 
                                       value="{{ old('Fecha_Pago', now()->format('Y-m-d\TH:i')) }}" 
                                       class="input-hatil" required>
                            </div>

                            {{-- ESTADO --}}
                            <div>
                                <span class="label-tiny">Estado Final</span>
                                <select name="Estado_Pago" id="Estado_Pago" class="input-hatil" required>
                                    @foreach ($estados as $estado)
                                        <option value="{{ $estado }}" {{ old('Estado_Pago', 'Completado') == $estado ? 'selected' : '' }}>
                                            {{ $estado }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- ACCIONES --}}
                    <div class="mt-12 pt-8 border-t border-slate-50 flex items-center justify-between">
                        <a href="{{ route('admin.pagos.index') }}" class="text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-slate-900 transition-all italic">
                            ← Cancelar Operación
                        </a>
                        <button type="submit" class="bg-slate-900 text-white px-12 py-5 rounded-[2rem] text-[10px] font-black uppercase tracking-[0.3em] shadow-2xl hover:bg-slate-800 transition-all italic">
                            Registrar Transacción
                        </button>
                    </div>
                </form>
            </div>
            
            <p class="text-center mt-12 text-[9px] font-black text-slate-300 uppercase tracking-[0.4em]">
                HATIL — FINANCIAL SECURITY & CONTROL
            </p>
        </div>
    </div>

    {{-- SCRIPT PARA AUTOCOMPLETAR MANTENIDO --}}
    <script>
        function autocompletar() {
            const select = document.getElementById('Pedido_id');
            const selectedOption = select.options[select.selectedIndex];
            const total = selectedOption.getAttribute('data-total');
            const metodo = selectedOption.getAttribute('data-metodo');

            if (total) {
                document.getElementById('Monto').value = total;
            }

            if (metodo) {
                const selectMetodo = document.getElementById('Metodo_Pago');
                for (let i = 0; i < selectMetodo.options.length; i++) {
                    if (selectMetodo.options[i].value === metodo) {
                        selectMetodo.selectedIndex = i;
                        break;
                    }
                }
            }
        }

        function applyHatilTheme() {
            const color = localStorage.getItem('hatil_theme_color') || '#0f172a';
            const header = document.getElementById('system-header-bg');
            if(header) header.style.backgroundColor = color;
        }
        document.addEventListener('DOMContentLoaded', applyHatilTheme);
    </script>
</x-app-layout>