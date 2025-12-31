<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800;900&display=swap');

        :root {
            /* Sincronizado con tu Dashboard */
            --dynamic-theme: #0f172a; 
            --dynamic-bg: #f8fafc;
        }

        .font-hatil { font-family: 'Inter', sans-serif; }

        .reveal {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Estilo premium para la tabla */
        .hatil-table-container {
            background: white;
            border-radius: 3rem;
            box-shadow: 0 20px 50px -20px rgba(0,0,0,0.05);
            border: 1px solid rgba(0,0,0,0.02);
        }

        .stock-badge {
            padding: 0.5rem 1.5rem;
            border-radius: 1rem;
            font-weight: 900;
            font-style: italic;
            letter-spacing: -0.05em;
        }
    </style>

    <x-slot name="header">
        <div id="system-header-bg" class="w-full transition-all duration-500 rounded-b-[2.5rem] shadow-2xl bg-slate-900" 
             style="background-color: var(--dynamic-theme)">
            <div class="max-w-7xl mx-auto px-6 py-10">
                <div class="reveal flex flex-col md:flex-row justify-between items-center gap-6">
                    <div>
                        <nav class="flex mb-2 text-white/30 text-[10px] font-black uppercase tracking-[0.4em]">
                            <span>LOGÍSTICA</span> <span class="mx-2">/</span> <span>INVENTARIO</span>
                        </nav>
                        <h2 class="font-hatil font-black text-4xl text-white tracking-tighter italic uppercase">
                            Gestión de <span class="text-white/40">Stock</span>
                        </h2>
                    </div>
                    
                    <div class="flex gap-4">
                        <div class="bg-white/10 px-6 py-3 rounded-2xl backdrop-blur-md border border-white/10 text-center">
                            <p class="text-[9px] font-black text-white/40 uppercase tracking-widest">Total SKUs</p>
                            <p class="text-xl font-black text-white italic">{{ count($muebles) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 min-h-screen font-hatil bg-[#f8fafc]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Mensajes de Notificación --}}
            @if (session('success'))
                <div class="mb-8 reveal bg-emerald-50 border border-emerald-100 p-5 rounded-[2rem] flex items-center gap-4 shadow-sm">
                    <span class="text-2xl">✅</span>
                    <p class="text-[11px] font-black text-emerald-700 uppercase tracking-widest">{{ session('success') }}</p>
                </div>
            @endif

            <div class="hatil-table-container p-10 reveal">
                <div class="flex justify-between items-center mb-10">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Inventario Actual de Muebles</h3>
                    <div class="h-1 w-20 rounded-full bg-slate-100"></div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-slate-50">
                                <th class="px-6 py-5 text-left text-[9px] font-black text-slate-400 uppercase tracking-widest">ID</th>
                                <th class="px-6 py-5 text-left text-[9px] font-black text-slate-400 uppercase tracking-widest">Producto</th>
                                <th class="px-6 py-5 text-center text-[9px] font-black text-slate-400 uppercase tracking-widest">Disponibilidad</th>
                                <th class="px-6 py-5 text-right text-[9px] font-black text-slate-400 uppercase tracking-widest">Gestión</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach ($muebles as $mueble)
                                <tr class="group hover:bg-slate-50/50 transition-all">
                                    {{-- ID Mueble --}}
                                    <td class="px-6 py-8 whitespace-nowrap">
                                        <span class="text-xs font-black text-slate-400 bg-slate-50 px-3 py-1.5 rounded-lg group-hover:bg-white transition-colors">
                                            #{{ $mueble->Mueble_id }}
                                        </span>
                                    </td>
                                    
                                    {{-- Nombre --}}
                                    <td class="px-6 py-8">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-black text-slate-900 italic uppercase tracking-tighter leading-none mb-1">
                                                {{ $mueble->Nombre }}
                                            </span>
                                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Colección Hatil Premium</span>
                                        </div>
                                    </td>
                                    
                                    {{-- Stock con lógica de color --}}
                                    <td class="px-6 py-8 text-center">
                                        @if ($mueble->inventario)
                                            <div class="inline-flex flex-col items-center">
                                                <span class="text-2xl font-black italic tracking-tighter @if($mueble->inventario->Cantidad < 5) text-red-500 @else text-slate-900 @endif">
                                                    {{ $mueble->inventario->Cantidad }}
                                                </span>
                                                <span class="text-[8px] font-black uppercase tracking-[0.2em] text-slate-400">Unidades</span>
                                            </div>
                                        @else
                                            <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Sin Registro</span>
                                        @endif
                                    </td>
                                    
                                    {{-- Acciones --}}
                                    <td class="px-6 py-8 text-right">
                                        <a href="{{ route('admin.stock.edit', $mueble->Mueble_id) }}" 
                                           class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-slate-900 text-white text-[9px] font-black uppercase tracking-widest italic hover:scale-105 transition-transform shadow-lg shadow-slate-200">
                                            <span>Ajustar Stock</span>
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            {{-- Footer informativo --}}
            <div class="mt-8 px-10 flex justify-between items-center text-[9px] font-black text-slate-400 uppercase tracking-[0.4em]">
                <p>© Hatil Management System</p>
                <div class="flex gap-4">
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-red-500"></span> Stock Crítico</span>
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-slate-900"></span> Stock Estable</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Aplicar el color del tema guardado en localStorage
            const themeColor = localStorage.getItem('hatil_theme_color') || '#0f172a';
            const header = document.getElementById('system-header-bg');
            if(header) header.style.backgroundColor = themeColor;
        });
    </script>
</x-app-layout>