<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800;900&display=swap');

        :root {
            --dynamic-theme: #0f172a;
            --dynamic-bg: #f8fafc;
        }

        .font-hatil { font-family: 'Inter', sans-serif; }

        .reveal {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Estilo de Filas de Tabla */
        .order-row {
            background-color: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .order-row:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px -10px rgba(0,0,0,0.05);
            z-index: 10;
            position: relative;
        }

        .btn-dynamic {
            background-color: var(--dynamic-theme);
            transition: all 0.3s ease;
        }
        .btn-dynamic:hover { 
            filter: brightness(1.2); 
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -5px rgba(0,0,0,0.2);
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 1rem;
            font-size: 9px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
    </style>

    <x-slot name="header">
        <div id="system-header-bg" class="w-full transition-all duration-500 rounded-b-[3.5rem] shadow-2xl">
            <div class="max-w-7xl mx-auto px-6 py-10">
                <div class="reveal flex flex-col md:flex-row justify-between items-center gap-6">
                    <div>
                        <nav class="flex mb-2 text-white/30 text-[10px] font-black uppercase tracking-[0.4em]">
                            <span>HATIL MANAGEMENT</span> <span class="mx-2">/</span> <span>LOGÍSTICA</span>
                        </nav>
                        <h2 class="font-hatil font-black text-4xl text-white tracking-tighter italic uppercase">
                            Gestión de <span class="text-white/40">Pedidos</span>
                        </h2>
                    </div>
                    
                    <a href="{{ route('admin.pedidos.create') }}" 
                       class="bg-white text-slate-900 font-black uppercase text-[11px] px-8 py-4 rounded-2xl tracking-[0.2em] italic shadow-xl hover:scale-105 transition-all flex items-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
                        Nuevo Pedido
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div id="main-wrapper" class="py-12 min-h-screen transition-all duration-500 font-hatil">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Mensajes de Éxito --}}
            @if (session('success'))
                <div class="bg-emerald-500 text-white p-5 rounded-[2rem] mb-8 reveal shadow-lg flex items-center gap-4 border-b-4 border-emerald-700">
                    <span class="text-xl">✅</span>
                    <p class="text-xs font-black uppercase tracking-widest">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white/50 backdrop-blur-md rounded-[3rem] overflow-hidden shadow-sm border border-white">
                <div class="overflow-x-auto">
                    @if ($pedidos->isEmpty())
                        <div class="text-center py-24 reveal">
                            <div class="text-6xl mb-4 opacity-20">📦</div>
                            <h3 class="text-slate-400 font-black uppercase tracking-[0.3em] italic text-[10px]">No hay pedidos registrados en el sistema</h3>
                        </div>
                    @else
                        <table class="w-full text-left border-separate border-spacing-y-3 px-6">
                            <thead>
                                <tr class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">
                                    <th class="px-6 py-4">ID / Registro</th>
                                    <th class="px-6 py-4">Información del Cliente</th>
                                    <th class="px-6 py-4">Monto Total</th>
                                    <th class="px-6 py-4 text-center">Estado actual</th>
                                    <th class="px-6 py-4 text-right">Gestión</th>
                                </tr>
                            </thead>
                            <tbody class="reveal">
                                @foreach ($pedidos as $pedido)
                                    <tr class="order-row group">
                                        {{-- ID y Fecha --}}
                                        <td class="px-6 py-6 rounded-l-[2rem] border-y border-l border-slate-50">
                                            <div class="flex flex-col">
                                                <span class="text-sm font-black text-slate-900 italic">#ORD-{{ $pedido->Pedido_id }}</span>
                                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">
                                                    {{ is_object($pedido->Fecha_pedido) ? $pedido->Fecha_pedido->format('d M, Y') : $pedido->Fecha_pedido }}
                                                </span>
                                            </div>
                                        </td>

                                        {{-- Cliente --}}
                                        <td class="px-6 py-6 border-y border-slate-50">
                                            <div class="flex items-center gap-3">
                                                <div class="h-10 w-10 rounded-xl bg-slate-900 flex items-center justify-center text-white font-black text-xs">
                                                    {{ substr($pedido->usuario->name ?? 'U', 0, 1) }}
                                                </div>
                                                <div class="flex flex-col">
                                                    <span class="text-xs font-black text-slate-800 uppercase tracking-tight">{{ $pedido->usuario->name ?? 'UsuarioC #' . $pedido->UsuarioC_id }}</span>
                                                    <span class="text-[10px] font-medium text-slate-400">{{ $pedido->usuario->email ?? 'Sin correo' }}</span>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- Total --}}
                                        <td class="px-6 py-6 border-y border-slate-50">
                                            <span class="text-sm font-black text-slate-900">
                                                ${{ number_format($pedido->Total, 2) }}
                                            </span>
                                        </td>

                                        {{-- Estado --}}
                                        <td class="px-6 py-6 border-y border-slate-50 text-center">
                                            @php
                                                $statusStyles = match($pedido->Estado) {
                                                    'Pendiente'  => 'bg-amber-100 text-amber-700',
                                                    'Procesando' => 'bg-sky-100 text-sky-700',
                                                    'Enviado'    => 'bg-indigo-100 text-indigo-700',
                                                    'Completado' => 'bg-emerald-100 text-emerald-700',
                                                    'Cancelado'  => 'bg-rose-100 text-rose-700',
                                                    default      => 'bg-slate-100 text-slate-700',
                                                };
                                            @endphp
                                            <span class="status-badge {{ $statusStyles }}">
                                                {{ $pedido->Estado }}
                                            </span>
                                        </td>

                                        {{-- Acciones --}}
                                        <td class="px-6 py-6 rounded-r-[2rem] border-y border-r border-slate-50 text-right">
                                            <div class="flex justify-end items-center gap-2">
                                                <a href="{{ route('admin.pedidos.show', $pedido->Pedido_id) }}" class="p-3 bg-slate-50 rounded-xl hover:bg-slate-900 hover:text-white transition-all shadow-sm" title="Ver Detalles">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                                </a>

                                                <a href="{{ route('admin.pedidos.edit', $pedido->Pedido_id) }}" class="p-3 bg-slate-50 rounded-xl hover:bg-amber-500 hover:text-white transition-all shadow-sm" title="Editar">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                                </a>

                                                <a href="{{ route('admin.pedidos.pdf', $pedido->Pedido_id) }}" class="p-3 bg-slate-50 rounded-xl hover:bg-emerald-600 hover:text-white transition-all shadow-sm" title="PDF">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                                                </a>

                                                <form action="{{ route('admin.pedidos.destroy', $pedido->Pedido_id) }}" method="POST" onsubmit="return confirm('¿Eliminar pedido permanentemente?');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-3 bg-slate-50 rounded-xl hover:bg-rose-600 hover:text-white transition-all shadow-sm">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

                {{-- Paginación Estilizada --}}
                <div class="px-8 py-8 border-t border-slate-50">
                    {{ $pedidos->links() }}
                </div>
            </div>

            <p class="text-center mt-12 text-[9px] font-black text-slate-300 uppercase tracking-[0.4em]">
                Hatil Inventory & Sales Control — Real Time Updates
            </p>
        </div>
    </div>

    <script>
        function applyHatilTheme() {
            const color = localStorage.getItem('hatil_theme_color') || '#065f46';
            const bgColor = localStorage.getItem('hatil_bg_color') || '#ecfdf5';
            
            document.documentElement.style.setProperty('--dynamic-theme', color);
            document.documentElement.style.setProperty('--dynamic-bg', bgColor);

            const header = document.getElementById('system-header-bg');
            const wrapper = document.getElementById('main-wrapper');
            
            if(header) header.style.backgroundColor = color;
            if(wrapper) wrapper.style.backgroundColor = bgColor;
        }
        document.addEventListener('DOMContentLoaded', applyHatilTheme);
    </script>
</x-app-layout>