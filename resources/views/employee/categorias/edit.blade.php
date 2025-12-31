{{-- resources/views/admin/categorias/edit.blade.php --}}
<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800;900&display=swap');
        .font-hatil { font-family: 'Inter', sans-serif; }
        .label-tiny { font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.2em; color: #94a3b8; display: block; margin-bottom: 0.75rem; }
        .input-hatil { width: 100%; background-color: #f8fafc; border: 2px solid #f1f5f9; border-radius: 1.25rem; padding: 1rem 1.25rem; font-size: 13px; font-weight: 700; color: #1e293b; transition: all 0.3s; }
        .input-hatil:focus { outline: none; border-color: #0f172a; background-color: #fff; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); }
        .reveal { animation: fadeInUp 0.5s ease-out forwards; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    </style>

    <x-slot name="header">
        <div class="w-full rounded-b-[4rem] shadow-2xl bg-slate-900 overflow-hidden">
            <div class="max-w-7xl mx-auto px-6 py-12 reveal">
                <nav class="flex mb-3 text-white/30 text-[10px] font-black uppercase tracking-[0.5em]">
                    <span>ADMINISTRACIÓN</span> <span class="mx-2">/</span> <span>EDICIÓN DE COLECCIÓN</span>
                </nav>
                <h2 class="font-hatil font-black text-4xl text-white tracking-tighter italic uppercase leading-none">
                    Editar <span class="text-white/40">{{ $categoria->Nombre }}</span>
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen font-hatil">
        <div class="max-w-3xl mx-auto px-6 lg:px-8">
            
            <div class="bg-white p-10 rounded-[4rem] shadow-sm border border-slate-100 reveal">
                <div class="mb-10 flex justify-between items-center">
                    <div>
                        <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest italic">Actualizar Información</h3>
                        <p class="text-[11px] text-slate-400 font-bold uppercase tracking-tighter">ID de Registro: #{{ str_pad($categoria->Categoria_id, 3, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div class="h-12 w-12 bg-slate-50 rounded-2xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </div>
                </div>

                <form action="{{ route('admin.categorias.update', $categoria->Categoria_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Campo Nombre --}}
                    <div class="mb-8">
                        <label for="nombre" class="label-tiny">Nombre de la Colección</label>
                        <input type="text" 
                               name="nombre" 
                               id="nombre" 
                               value="{{ old('nombre', $categoria->Nombre) }}" 
                               required 
                               class="input-hatil @error('nombre') border-red-300 @enderror">
                        @error('nombre')
                            <p class="text-red-500 text-[10px] font-black uppercase mt-2 tracking-widest">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Campo Descripción --}}
                    <div class="mb-10">
                        <label for="descripcion" class="label-tiny">Descripción Comercial</label>
                        <textarea name="descripcion" 
                                  id="descripcion" 
                                  rows="5" 
                                  required 
                                  class="input-hatil @error('descripcion') border-red-300 @enderror" 
                                  style="border-radius: 1.5rem;">{{ old('descripcion', $categoria->Descripcion) }}</textarea>
                        @error('descripcion')
                            <p class="text-red-500 text-[10px] font-black uppercase mt-2 tracking-widest">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Botones de Acción --}}
                    <div class="flex items-center justify-between pt-8 border-t border-slate-50">
                        <a href="{{ route('admin.categorias.index') }}" 
                           class="text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-slate-900 transition-all italic">
                            ← Cancelar y Volver
                        </a>
                        
                        <button type="submit" 
                                class="bg-indigo-600 text-white px-10 py-5 rounded-[2rem] text-[10px] font-black uppercase tracking-[0.3em] shadow-2xl hover:bg-indigo-700 transition-all italic hover:-translate-y-1">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>

            <div class="mt-8 flex justify-center space-x-4 reveal" style="animation-delay: 0.2s">
                <span class="h-1 w-1 bg-slate-200 rounded-full"></span>
                <span class="h-1 w-1 bg-slate-200 rounded-full"></span>
                <span class="h-1 w-1 bg-slate-200 rounded-full"></span>
            </div>
        </div>
    </div>
</x-app-layout>