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

        .label-tiny {
            font-size: 9px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: #94a3b8;
        }

        /* Alineación Horizontal Forzada */
        .payment-grid-row {
            display: grid;
            grid-template-columns: 0.8fr 1.5fr 1fr 1.2fr 1.2fr 1fr;
            align-items: center;
            gap: 1.5rem;
        }

        .status-pill {
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 9px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
    </style>

    <x-slot name="header">
        <div id="system-header-bg" class="w-full transition-all duration-500 rounded-b-[4rem] shadow-2xl bg-slate-900">
            <div class="max-w-7xl mx-auto px-6 py-12">
                <div class="reveal flex justify-between items-center">
                    <div>
                        <nav class="flex mb-3 text-white/30 text-[10px] font-black uppercase tracking-[0.5em]">
                            <span>FINANZAS</span> <span class="mx-2">/</span> <span>CONTROL DE CAJA</span>
                        </nav>
                        <h2 class="font-hatil font-black text-4xl text-white tracking-tighter italic uppercase leading-none">
                            Gestión de <span class="text-white/40">Pagos</span>
                        </h2>
                    </div>
                    <a href="{{ route('admin.pagos.create') }}" class="group bg-white text-slate-900 px-8 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-500 hover:text-white transition-all shadow-xl flex items-center gap-3">
                        <span class="text-lg">+</span> Registrar Nuevo Pago
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div id="main-wrapper" class="py-12 min-h-screen font-hatil bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-white p-10 rounded-[4rem] shadow-sm border border-slate-100 reveal">
                
                {{-- CABECERA DE LA TABLA --}}
                <div class="payment-grid-row px-8 mb-6 border-b border-slate-50 pb-4">
                    <span class="label-tiny">ID Pago</span>
                    <span class="label-tiny">Monto Operación</span>
                    <span class="label-tiny">Fecha Registro</span>
                    <span class="label-tiny">Método</span>
                    <span class="label-tiny">Estado</span>
                    <span class="label-tiny text-right">Acciones</span>
                </div>

                <div class="space-y-3">
                    @forelse ($pagos as $pago)
                        <div class="payment-grid-row bg-slate-50 hover:bg-slate-100 transition-all px-8 py-5 rounded-[2rem] border border-transparent hover:border-slate-200">
                            
                            {{-- ID --}}
                            <span class="text-xs font-black text-slate-400">#{{ $pago->Pago_id }}</span>

                            {{-- MONTO (Bs) --}}
                            <span class="text-sm font-black text-slate-900 italic tracking-tighter">
                                Bs {{ number_format($pago->Monto, 2) }}
                            </span>

                            {{-- FECHA --}}
                            <span class="text-[11px] font-bold text-slate-500 uppercase">
                                {{ $pago->Fecha_pago?->format('d M, Y') ?? 'N/A' }}
                            </span>

                            {{-- MÉTODO --}}
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                {{ $pago->Metodo_Pago }}
                            </span>

                            {{-- ESTADO --}}
                            <div>
                                <span class="status-pill 
                                    @if($pago->Estado === 'Completado') bg-emerald-100 text-emerald-600 
                                    @elseif($pago->Estado === 'Pendiente') bg-amber-100 text-amber-600 
                                    @else bg-rose-100 text-rose-600 @endif">
                                    {{ $pago->Estado }}
                                </span>
                            </div>

                            {{-- ACCIONES --}}
                            <div class="flex justify-end gap-3">
                                <a href="{{ route('admin.pagos.edit', $pago->Pago_id) }}" class="text-[10px] font-black text-indigo-500 uppercase hover:text-indigo-700 transition-colors">Editar</a>
                                
                                <form action="{{ route('admin.pagos.destroy', $pago->Pago_id) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar registro contable?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-[10px] font-black text-rose-400 uppercase hover:text-rose-600 transition-colors">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="py-20 text-center">
                            <p class="label-tiny text-slate-300">No hay registros de pagos disponibles</p>
                        </div>
                    @endforelse
                </div>

                {{-- PAGINACIÓN --}}
                <div class="mt-10 px-4">
                    {{ $pagos->links() }}
                </div>
            </div>

            <p class="text-center mt-12 text-[9px] font-black text-slate-300 uppercase tracking-[0.4em]">
                HATIL ARCHITECTURE & FURNITURE — SISTEMA FINANCIERO v2.0
            </p>
        </div>
    </div>

    <script>
        function applyHatilTheme() {
            const color = localStorage.getItem('hatil_theme_color') || '#0f172a';
            const header = document.getElementById('system-header-bg');
            if(header) header.style.backgroundColor = color;
        }
        document.addEventListener('DOMContentLoaded', applyHatilTheme);
    </script>
</x-app-layout>