<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800;900&display=swap');
        :root { --dynamic-theme: #0f172a; }
        .font-hatil { font-family: 'Inter', sans-serif; }
        
        .reveal { animation: fadeInUp 0.6s ease-out forwards; }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Estilo para convertir Radio Buttons en Tarjetas Seleccionables */
        .status-radio { display: none; }
        .status-card {
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid #f1f5f9;
        }
        
        .status-radio:checked + .status-card {
            border-color: var(--dynamic-theme);
            background-color: #f8fafc;
            transform: scale(1.02);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
        }

        .label-tiny {
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: #94a3b8;
        }
    </style>

    <x-slot name="header">
        <div id="system-header-bg" class="w-full transition-all duration-500 rounded-b-[4rem] shadow-2xl bg-slate-900">
            <div class="max-w-7xl mx-auto px-6 py-12">
                <div class="reveal flex justify-between items-center">
                    <div>
                        <nav class="flex mb-3 text-white/30 text-[10px] font-black uppercase tracking-[0.5em]">
                            <span>LOGÍSTICA</span> <span class="mx-2">/</span> <span>GESTIÓN DE ESTADOS</span>
                        </nav>
                        <h2 class="font-hatil font-black text-4xl text-white tracking-tighter italic uppercase leading-none">
                            Actualizar <span class="text-white/40">Pedido #{{ $pedido->Pedido_id }}</span>
                        </h2>
                    </div>
                    <a href="{{ route('admin.pedidos.index') }}" class="bg-white/10 text-white px-6 py-3 rounded-xl border border-white/10 text-[9px] font-black uppercase tracking-widest hover:bg-white/20 transition-all italic">
                        ← Regresar
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div id="main-wrapper" class="py-12 min-h-screen font-hatil bg-slate-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-white p-12 rounded-[4rem] shadow-sm border border-slate-100 reveal">
                <form action="{{ route('admin.pedidos.update', $pedido->Pedido_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h3 class="text-[11px] font-black text-slate-900 uppercase tracking-[0.4em] mb-10 italic border-l-4 border-slate-900 pl-4">
                        Seleccione el nuevo estado operativo
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-12">
                        @php
                            $estados = [
                                ['id' => 'Pendiente', 'label' => 'Pendiente', 'color' => 'bg-amber-500', 'desc' => 'En cola de espera'],
                                ['id' => 'Procesando', 'label' => 'Procesando', 'color' => 'bg-blue-500', 'desc' => 'Preparando envío'],
                                ['id' => 'Enviado', 'label' => 'Enviado', 'color' => 'bg-indigo-500', 'desc' => 'Producto en ruta'],
                                ['id' => 'Completado', 'label' => 'Completado', 'color' => 'bg-emerald-500', 'desc' => 'Entrega finalizada'],
                                ['id' => 'Cancelado', 'label' => 'Cancelado', 'color' => 'bg-rose-500', 'desc' => 'Anulado por sistema'],
                            ];
                        @endphp

                        @foreach($estados as $e)
                            <label class="relative">
                                <input type="radio" name="Estado" value="{{ $e['id'] }}" class="status-radio" {{ $pedido->Estado == $e['id'] ? 'checked' : '' }}>
                                <div class="status-card p-6 rounded-[2rem] bg-white h-full flex flex-col items-start gap-2 group">
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full {{ $e['color'] }}"></div>
                                        <span class="text-xs font-black uppercase italic text-slate-900">{{ $e['label'] }}</span>
                                    </div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">{{ $e['desc'] }}</p>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    {{-- INFORMACIÓN DEL PEDIDO --}}
                    <div class="bg-slate-50 rounded-[3rem] p-8 mb-10 flex justify-between items-center border border-slate-100">
                        <div>
                            <span class="label-tiny">Importe del Pedido</span>
                            <p class="text-xl font-black text-slate-900 italic tracking-tighter">Bs {{ number_format($pedido->Total, 2) }}</p>
                        </div>
                        <div class="text-right">
                            <span class="label-tiny">Cliente</span>
                            <p class="text-xs font-black text-slate-800 uppercase italic">{{ $pedido->usuario->name ?? 'N/A' }}</p>
                        </div>
                    </div>

                    {{-- BOTONES --}}
                    <div class="flex flex-col gap-4">
                        <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-[2rem] text-[10px] font-black uppercase tracking-[0.4em] shadow-xl hover:bg-slate-800 transition-all italic">
                            Guardar Cambios de Estatus
                        </button>
                    </div>
                </form>
            </div>

            <p class="text-center mt-12 text-[9px] font-black text-slate-300 uppercase tracking-[0.4em]">
                HATIL — INTERNAL LOGISTICS SYSTEM
            </p>
        </div>
    </div>

    <script>
        function applyHatilTheme() {
            const color = localStorage.getItem('hatil_theme_color') || '#0f172a';
            document.documentElement.style.setProperty('--dynamic-theme', color);
            const header = document.getElementById('system-header-bg');
            if(header) header.style.backgroundColor = color;
        }
        document.addEventListener('DOMContentLoaded', applyHatilTheme);
    </script>
</x-app-layout>