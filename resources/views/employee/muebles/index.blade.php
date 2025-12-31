{{-- resources/views/employee/muebles/index.blade.php --}}
@php
use Illuminate\Support\Str; 
@endphp

<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800;900&display=swap');
        .font-hatil { font-family: 'Inter', sans-serif; }
        .reveal { animation: fadeInUp 0.4s ease-out forwards; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        
        /* Estilo de la tabla HATIL */
        .hatil-table { width: 100%; border-collapse: separate; border-spacing: 0 0.5rem; }
        .hatil-table thead th { font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.15em; color: #94a3b8; padding: 1.5rem 1rem; }
        .hatil-table tbody tr { background-color: white; transition: all 0.3s; box-shadow: 0 1px 3px rgba(0,0,0,0.02); }
        .hatil-table tbody tr:hover { transform: scale(1.005); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
        .hatil-table td { padding: 1.25rem 1rem; font-size: 13px; font-weight: 600; color: #1e293b; border: none; }
        .hatil-table td:first-child { border-radius: 1.5rem 0 0 1.5rem; }
        .hatil-table td:last-child { border-radius: 0 1.5rem 1.5rem 0; }
        
        .badge-hatil { padding: 0.4rem 0.8rem; border-radius: 0.75rem; font-size: 10px; font-weight: 800; text-transform: uppercase; }
        .input-search { border: 2px solid #f1f5f9; border-radius: 1.25rem; transition: all 0.3s; }
        .input-search:focus { border-color: #0f172a; outline: none; box-shadow: none; }
    </style>

    <x-slot name="header">
        <div class="w-full rounded-b-[4rem] shadow-2xl bg-slate-900 overflow-hidden">
            <div class="max-w-7xl mx-auto px-6 py-12 reveal">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                    <div>
                        <nav class="flex mb-3 text-white/30 text-[10px] font-black uppercase tracking-[0.5em]">
                            <span>ADMINISTRACIÓN</span> <span class="mx-2">/</span> <span>INVENTARIO</span>
                        </nav>
                        <h2 class="font-hatil font-black text-4xl text-white tracking-tighter italic uppercase leading-none">
                            Catálogo de <span class="text-white/40">Muebles</span>
                        </h2>
                    </div>
                    <a href="{{ route('admin.muebles.create') }}" class="bg-white text-slate-900 px-8 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:scale-105 transition-all italic shadow-xl">
                        + Nuevo Mueble
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen font-hatil">
        <div class="max-w-[95%] mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- ALERTAS --}}
            @if (session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-2xl text-emerald-800 text-xs font-bold reveal">
                    {{ session('success') }}
                </div>
            @endif

            {{-- BUSCADOR --}}
            <div class="bg-white p-6 rounded-[2.5rem] shadow-sm mb-8 reveal">
                <form method="GET" action="{{ route('admin.muebles.index') }}" class="flex flex-col md:flex-row gap-4 items-center">
                    <div class="relative w-full md:w-1/2">
                        <input type="text" name="search" placeholder="Buscar por nombre, material o color..." 
                               value="{{ request('search') }}" class="input-search w-full py-3 px-6 text-sm font-semibold">
                    </div>
                    <button type="submit" class="bg-slate-900 text-white px-8 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-800 transition-all">
                        Filtrar Resultados
                    </button>
                    @if (request()->has('search') && !empty(request('search')))
                        <a href="{{ route('admin.muebles.index') }}" class="text-[10px] font-black uppercase text-red-500 hover:underline">
                            Limpiar
                        </a>
                    @endif
                </form>
            </div>

            {{-- TABLA --}}
            <div class="overflow-x-auto reveal" style="animation-delay: 0.2s">
                <table class="hatil-table">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Proveedor</th>
                            <th>Material / Color</th>
                            <th>Precio</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th class="text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($muebles as $mueble)
                            <tr>
                                <td>
                                    @if($mueble->imagen)
                                        <img src="{{ asset('storage/' . $mueble->imagen) }}" class="h-12 w-12 rounded-2xl object-cover shadow-md border-2 border-slate-100">
                                    @else
                                        <div class="h-12 w-12 bg-slate-100 rounded-2xl flex items-center justify-center border-2 border-dashed border-slate-200 text-[8px] font-black text-slate-400 uppercase">N/A</div>
                                    @endif
                                </td>
                                <td class="font-black text-slate-900 uppercase italic leading-tight">
                                    {{ $mueble->nombre }}
                                </td>
                                <td><span class="text-slate-400">#</span> {{ $mueble->categoria->Nombre ?? 'S/C' }}</td>
                                <td>{{ $mueble->proveedor->Nombre ?? 'Sin Prov.' }}</td>
                                <td>
                                    <div class="flex flex-col">
                                        <span class="text-slate-900 uppercase text-[11px]">{{ $mueble->Material }}</span>
                                        <span class="text-slate-400 text-[10px]">{{ $mueble->Color }}</span>
                                    </div>
                                </td>
                                <td class="text-slate-900 font-black italic">
                                    Bs. {{ number_format($mueble->Precio, 2) }}
                                </td>
                                <td class="max-w-[150px]">
                                    <p class="truncate text-[11px] text-slate-400">{{ $mueble->Descripcion }}</p>
                                </td>
                                <td>
                                    <span class="badge-hatil {{ strtolower($mueble->Estado) == 'disponible' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                        {{ $mueble->Estado }}
                                    </span>
                                </td>
                                <td class="text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.muebles.edit', $mueble->Mueble_id) }}" class="p-2 bg-slate-100 text-slate-600 rounded-xl hover:bg-slate-900 hover:text-white transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </a>
                                        <form action="{{ route('admin.muebles.destroy', $mueble->Mueble_id) }}" method="POST" onsubmit="return confirm('¿Eliminar {{ $mueble->nombre }}?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 bg-red-50 text-red-500 rounded-xl hover:bg-red-500 hover:text-white transition-all">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-20">
                                    <span class="text-slate-300 font-black uppercase tracking-widest italic">No se encontraron muebles</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-8">
                {{ $muebles->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</x-app-layout>