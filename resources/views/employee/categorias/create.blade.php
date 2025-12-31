{{-- resources/views/admin/categorias/create.blade.php --}}
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
                    <span>ADMINISTRACIÓN</span> <span class="mx-2">/</span> <span>NUEVA COLECCIÓN</span>
                </nav>
                <h2 class="font-hatil font-black text-4xl text-white tracking-tighter italic uppercase leading-none">
                    Crear <span class="text-white/40">Categoría</span>
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen font-hatil">
        <div class="max-w-3xl mx-auto px-6 lg:px-8">
            
            <div class="bg-white p-10 rounded-[4rem] shadow-sm border border-slate-100 reveal">
                <div class="mb-10">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest italic">Detalles Técnicos</h3>
                    <p class="text-[11px] text-slate-400 font-bold uppercase tracking-tighter">Define las características de la nueva línea de productos</p>
                </div>

                <form action="{{ route('admin.categorias.store') }}" method="POST">
                    @csrf

                    {{-- Campo Nombre --}}
                    <div class="mb-8">
                        <label for="nombre" class="label-tiny">Nombre de la Colección</label>
                        <input type="text" 
                               name="nombre" 
                               id="nombre" 
                               placeholder="Ej: Minimalist Executive 2024"
                               value="{{ old('nombre') }}" 
                               required 
                               autofocus
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
                                  placeholder="Describe el estilo, acabados y público objetivo de esta categoría..."
                                  required 
                                  class="input-hatil style-textarea @error('descripcion') border-red-300 @enderror" 
                                  style="border-radius: 1.5rem;">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <p class="text-red-500 text-[10px] font-black uppercase mt-2 tracking-widest">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Botones de Acción --}}
                    <div class="flex items-center justify-between pt-8 border-t border-slate-50">
                        <a href="{{ route('admin.categorias.index') }}" 
                           class="text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-slate-900 transition-all italic">
                            ← Cancelar Registro
                        </a>
                        
                        <button type="submit" 
                                class="bg-slate-900 text-white px-10 py-5 rounded-[2rem] text-[10px] font-black uppercase tracking-[0.3em] shadow-2xl hover:bg-slate-800 transition-all italic hover:-translate-y-1">
                            Guardar Colección
                        </button>
                    </div>
                </form>
            </div>

            {{-- Info Footer --}}
            <div class="mt-8 text-center reveal" style="animation-delay: 0.2s">
                <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.4em]">Hatil International Management System</p>
            </div>
        </div>
    </div>
</x-app-layout>