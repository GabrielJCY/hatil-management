{{-- resources/views/admin/proveedores/create.blade.php --}}
<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800;900&display=swap');
        .font-hatil { font-family: 'Inter', sans-serif; }
        .label-tiny { font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.2em; color: #94a3b8; display: block; margin-bottom: 0.75rem; }
        
        /* Estilo de Input basado en tu captura */
        .input-hatil { width: 100%; background-color: #f8fafc; border: 2px solid #f1f5f9; border-radius: 2rem; padding: 1rem 1.5rem; font-size: 14px; font-weight: 700; color: #1e293b; transition: all 0.3s; }
        .input-hatil:focus { outline: none; border-color: #10b981; background-color: #fff; }

        .reveal { animation: fadeInUp 0.5s ease-out forwards; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    </style>

    <x-slot name="header">
        <div class="w-full rounded-b-[4rem] shadow-2xl bg-slate-900 overflow-hidden">
            <div class="max-w-7xl mx-auto px-6 py-12 reveal">
                <nav class="flex mb-3 text-white/30 text-[10px] font-black uppercase tracking-[0.5em]">
                    <span>ADMINISTRACIÓN</span> <span class="mx-2">/</span> <span>PARTNERS</span>
                </nav>
                <h2 class="font-hatil font-black text-4xl text-white tracking-tighter italic uppercase leading-none">
                    Crear Nuevo <span class="text-emerald-400/60">Proveedor</span>
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen font-hatil">
        <div class="max-w-4xl mx-auto px-6 lg:px-8"> 
            <div class="bg-white p-10 rounded-[4rem] shadow-sm border border-slate-100 reveal">
                
                <form method="POST" action="{{ route('admin.proveedores.store') }}">
                    @csrf

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        
                        {{-- Nombre --}}
                        <div class="sm:col-span-2"> 
                            <label for="Nombre" class="label-tiny">Nombre de la Empresa</label>
                            <input id="Nombre" name="Nombre" type="text" class="input-hatil" value="{{ old('Nombre') }}" required autofocus />
                            <x-input-error class="mt-2 text-[10px] font-black uppercase tracking-widest" :messages="$errors->get('Nombre')" />
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="Email" class="label-tiny">Email</label>
                            <input id="Email" name="Email" type="email" class="input-hatil" value="{{ old('Email') }}" required />
                            <x-input-error class="mt-2 text-[10px] font-black uppercase tracking-widest" :messages="$errors->get('Email')" />
                        </div>

                        {{-- Teléfono (Corregido: +000 00000000) --}}
                        <div>
                            <label for="Telefono" class="label-tiny">Línea de Contacto</label>
                            <input id="Telefono" name="Telefono" type="text" class="input-hatil" placeholder="+000 00000000" value="{{ old('Telefono') }}" />
                            <x-input-error class="mt-2 text-[10px] font-black uppercase tracking-widest" :messages="$errors->get('Telefono')" />
                        </div>

                        {{-- Dirección --}}
                        <div class="sm:col-span-2">
                            <label for="Direccion" class="label-tiny">Dirección Completa</label>
                            <input id="Direccion" name="Direccion" type="text" class="input-hatil" value="{{ old('Direccion') }}" />
                            <x-input-error class="mt-2 text-[10px] font-black uppercase tracking-widest" :messages="$errors->get('Direccion')" />
                        </div>

                        {{-- Ciudad --}}
                        <div>
                            <label for="Ciudad" class="label-tiny">Ciudad</label>
                            <input id="Ciudad" name="Ciudad" type="text" class="input-hatil" value="{{ old('Ciudad') }}" required />
                            <x-input-error class="mt-2 text-[10px] font-black uppercase tracking-widest" :messages="$errors->get('Ciudad')" />
                        </div>
                        
                        {{-- País --}}
                        <div>
                            <label for="Pais" class="label-tiny">País</label>
                            <input id="Pais" name="Pais" type="text" class="input-hatil" value="{{ old('Pais') }}" required />
                            <x-input-error class="mt-2 text-[10px] font-black uppercase tracking-widest" :messages="$errors->get('Pais')" />
                        </div>
                        
                    </div>
                    
                    <div class="flex items-center justify-end mt-12 pt-8 border-t border-slate-50">
                        <a href="{{ route('admin.proveedores.index') }}" class="text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-slate-900 transition-all italic mr-8">
                            Cancelar
                        </a>
                        <button type="submit" class="bg-emerald-500 text-white px-10 py-4 rounded-full text-[10px] font-black uppercase tracking-[0.3em] shadow-xl hover:bg-emerald-600 transition-all italic hover:-translate-y-1">
                            Guardar Proveedor
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>