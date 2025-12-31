<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800;900&display=swap');
        :root { --dynamic-theme: #0f172a; --dynamic-bg: #f8fafc; }
        .font-hatil { font-family: 'Inter', sans-serif; }
        
        /* Contenedor de la Fila con Grid Forzado para alineación horizontal */
        .hatil-grid-row {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr; 
            align-items: center;
            gap: 1rem;
        }

        .label-tiny {
            font-size: 9px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: #94a3b8;
        }

        .status-pill {
            padding: 0.5rem 1.25rem;
            border-radius: 9999px;
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
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
                <div class="reveal flex justify-between items-center">
                    <div>
                        <nav class="flex mb-3 text-white/30 text-[10px] font-black uppercase tracking-[0.5em]">
                            <span>LOGÍSTICA</span> <span class="mx-2">/</span> <span>ORDEN #{{ $pedido->Pedido_id }}</span>
                        </nav>
                        <h2 class="font-hatil font-black text-4xl text-white tracking-tighter italic uppercase leading-none">
                            Detalles del <span class="text-white/40">Pedido</span>
                        </h2>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('admin.pedidos.index') }}" class="bg-white/10 text-white px-6 py-3 rounded-xl border border-white/10 text-[9px] font-black uppercase tracking-widest hover:bg-white/20 transition-all">← Volver</a>
                        <a href="{{ route('admin.pedidos.pdf', $pedido->Pedido_id) }}" class="bg-emerald-500 text-white px-6 py-3 rounded-xl text-[9px] font-black uppercase tracking-widest shadow-lg">Descargar PDF</a>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div id="main-wrapper" class="py-12 min-h-screen font-hatil bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
                {{-- INFO GENERAL --}}
                <div class="lg:col-span-2 bg-white p-10 rounded-[3rem] shadow-sm border border-slate-100 reveal">
                    <div class="grid grid-cols-3 gap-8 border-b border-slate-50 pb-10">
                        <div>
                            <span class="label-tiny">Fecha</span>
                            <p class="font-black text-slate-900 italic uppercase tracking-tighter">{{ is_object($pedido->Fecha_pedido) ? $pedido->Fecha_pedido->format('d/m/Y') : $pedido->Fecha_pedido }}</p>
                        </div>
                        <div>
                            <span class="label-tiny">Estado</span>
                            <span class="status-pill bg-blue-50 text-blue-600 inline-block mt-1">{{ $pedido->Estado }}</span>
                        </div>
                        <div>
                            <span class="label-tiny">Total</span>
                            <p class="text-2xl font-black text-slate-900 italic underline decoration-blue-500 decoration-4 underline-offset-4">Bs {{ number_format($pedido->Total, 2) }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-8 mt-10">
                        <div>
                            <span class="label-tiny">Cliente</span>
                            <p class="text-xs font-black text-slate-800 uppercase italic">{{ $pedido->usuario->name ?? 'Externo' }}</p>
                        </div>
                        <div>
                            <span class="label-tiny">Empleado</span>
                            <p class="text-xs font-black text-slate-800 uppercase italic">{{ $pedido->empleado->name ?? 'Sin asignar' }}</p>
                        </div>
                        <div>
                            <span class="label-tiny">Dirección</span>
                            <p class="text-[10px] font-bold text-slate-500 uppercase">{{ $pedido->Direccion_envio ?? 'Tienda' }}</p>
                        </div>
                    </div>
                </div>

                {{-- SIDEBAR SEGURIDAD --}}
                <div class="bg-slate-900 p-10 rounded-[3rem] shadow-xl text-white relative overflow-hidden reveal">
                    <span class="label-tiny text-white/30">Acciones de Control</span>
                    <p class="text-xs mt-4 mb-8 font-medium italic opacity-70">El borrado de este pedido liberará los productos reservados en el inventario.</p>
                    <form action="{{ route('admin.pedidos.destroy', $pedido->Pedido_id) }}" method="POST" onsubmit="return confirm('¿Eliminar definitivamente?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full py-4 bg-white/10 hover:bg-rose-600 text-[10px] font-black uppercase tracking-widest rounded-2xl border border-white/10 transition-all italic">Eliminar Registro</button>
                    </form>
                </div>
            </div>

            {{-- TABLA DE ARTÍCULOS - ALINEACIÓN HORIZONTAL --}}
            <div class="bg-white p-12 rounded-[4rem] shadow-sm border border-slate-100 reveal">
                <h3 class="text-[11px] font-black text-slate-900 uppercase tracking-[0.4em] mb-12 italic border-l-4 border-slate-900 pl-4">Artículos Incluidos</h3>
                
                <div class="hatil-grid-row px-8 mb-6 border-b border-slate-50 pb-4">
                    <span class="label-tiny">Mueble / Descripción</span>
                    <span class="label-tiny text-right">Unitario</span>
                    <span class="label-tiny text-center">Cant.</span>
                    <span class="label-tiny text-right">Subtotal</span>
                </div>

                <div class="space-y-4">
                    @foreach ($pedido->detalles as $detalle)
                        <div class="hatil-grid-row bg-slate-50 hover:bg-slate-100 transition-all px-8 py-6 rounded-[2rem]">
                            <span class="text-sm font-black text-slate-900 uppercase italic tracking-tighter">
                                {{ $detalle->mueble->Nombre ?? 'Mueble No Encontrado' }}
                            </span>
                            <span class="text-sm font-bold text-slate-400 text-right">
                                Bs {{ number_format($detalle->Precio_Unitario, 2) }}
                            </span>
                            <div class="flex justify-center">
                                <span class="bg-white px-5 py-1 rounded-xl text-xs font-black shadow-sm border border-slate-200 italic">
                                    {{ $detalle->Cantidad }}
                                </span>
                            </div>
                            <span class="text-sm font-black text-slate-900 text-right">
                                Bs {{ number_format($detalle->Cantidad * $detalle->Precio_Unitario, 2) }}
                            </span>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12 pt-10 border-t border-slate-50 flex justify-end items-end gap-6 px-8">
                    <span class="label-tiny pb-2">Total del Pedido</span>
                    <span class="text-5xl font-black text-slate-900 italic tracking-tighter leading-none">
                        Bs {{ number_format($pedido->Total, 2) }}
                    </span>
                </div>
            </div>

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