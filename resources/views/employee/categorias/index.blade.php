{{-- resources/views/admin/categorias/index.blade.php --}}
<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800;900&display=swap');
        .font-hatil { font-family: 'Inter', sans-serif; }
        .reveal { animation: fadeInUp 0.5s ease-out forwards; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        
        .search-input { background: #f8fafc; border: 2px solid #f1f5f9; border-radius: 1.5rem; transition: all 0.3s; }
        .search-input:focus { border-color: #0f172a; background: white; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); }
        
        .category-card { background: white; border: 1px solid #f1f5f9; border-radius: 2rem; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        .category-card:hover { transform: translateY(-5px); box-shadow: 0 25px 50px -12px rgba(0,0,0,0.08); border-color: #0f172a; }
        
        .btn-hatil-dark { background: #0f172a; color: white; padding: 0.75rem 1.5rem; border-radius: 1.25rem; font-weight: 800; font-size: 11px; text-transform: uppercase; letter-spacing: 0.1em; transition: all 0.3s; }
        .btn-hatil-dark:hover { background: #1e293b; transform: scale(1.02); }
    </style>

    <x-slot name="header">
        <div class="w-full rounded-b-[4rem] shadow-2xl bg-slate-900 overflow-hidden">
            <div class="max-w-7xl mx-auto px-6 py-12 reveal">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <nav class="flex mb-3 text-white/30 text-[10px] font-black uppercase tracking-[0.5em]">
                            <span>ADMINISTRACIÓN</span> <span class="mx-2">/</span> <span>CATEGORÍAS</span>
                        </nav>
                        <h2 class="font-hatil font-black text-4xl text-white tracking-tighter italic uppercase leading-none">
                            Gestión de <span class="text-white/40">Colecciones</span>
                        </h2>
                    </div>
                    
                    <a href="{{ route('admin.categorias.create') }}" class="inline-flex items-center bg-white text-slate-900 px-8 py-4 rounded-2xl font-black text-[11px] uppercase tracking-widest hover:bg-slate-100 transition-all shadow-xl italic">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                        Nueva Categoría
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen font-hatil">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            
            {{-- SECCIÓN DE BÚSQUEDA --}}
            <div class="mb-10 reveal" style="animation-delay: 0.1s">
                <form method="GET" action="{{ route('admin.categorias.index') }}" class="flex flex-col md:flex-row gap-4 items-center">
                    <div class="relative w-full md:w-1/2">
                        <span class="absolute inset-y-0 left-4 flex items-center text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </span>
                        <input type="text" name="search" placeholder="Filtrar por nombre o descripción comercial..." 
                               value="{{ request('search') }}"
                               class="search-input w-full pl-12 pr-4 py-4 text-sm font-bold text-slate-700 focus:ring-0">
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <button type="submit" class="btn-hatil-dark italic">
                            Aplicar Filtro
                        </button>
                        
                        @if (request()->has('search') && !empty(request('search')))
                            <a href="{{ route('admin.categorias.index') }}" class="text-[10px] font-black text-red-500 uppercase tracking-widest hover:underline italic">
                                Limpiar Búsqueda
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- MENSAJES DE ESTADO --}}
            @if (session('success'))
                <div class="mb-8 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-2xl reveal shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-emerald-500 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span class="text-sm font-bold text-emerald-800 tracking-tight">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            {{-- LISTADO ESTILO CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 reveal" style="animation-delay: 0.2s">
                @forelse ($categorias as $categoria)
                    <div class="category-card p-8 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-4">
                                <span class="bg-slate-100 text-slate-500 text-[9px] font-black px-3 py-1 rounded-full tracking-widest">
                                    ID: {{ str_pad($categoria->Categoria_id, 3, '0', STR_PAD_LEFT) }}
                                </span>
                            </div>
                            <h3 class="text-xl font-black text-slate-900 uppercase italic tracking-tighter mb-3 leading-tight">
                                {{ $categoria->Nombre }}
                            </h3>
                            <p class="text-slate-500 text-xs font-semibold leading-relaxed line-clamp-3 mb-6">
                                {{ $categoria->Descripcion ?: 'Sin descripción técnica disponible.' }}
                            </p>
                        </div>

                        <div class="flex items-center justify-between pt-6 border-t border-slate-50">
                            <a href="{{ route('admin.categorias.edit', $categoria->Categoria_id) }}" 
                               class="text-[10px] font-black uppercase tracking-widest text-indigo-500 hover:text-indigo-700 transition-colors">
                                Editar
                            </a>
                            
                            <form action="{{ route('admin.categorias.destroy', $categoria->Categoria_id) }}" method="POST" 
                                  onsubmit="return confirm('¿Eliminar la colección {{ $categoria->Nombre }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-[10px] font-black uppercase tracking-widest text-red-400 hover:text-red-600 transition-colors">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <div class="inline-block p-6 bg-white rounded-[3rem] shadow-sm border border-slate-100">
                            <svg class="w-12 h-12 mx-auto text-slate-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                            <p class="text-sm font-black text-slate-400 uppercase tracking-widest">No se encontraron colecciones</p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- PAGINACIÓN --}}
            <div class="mt-12 reveal" style="animation-delay: 0.3s">
                {{ $categorias->links() }}
            </div>
        </div>
    </div>
</x-app-layout>