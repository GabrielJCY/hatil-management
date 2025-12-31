<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800;900&display=swap');

        :root {
            --dynamic-theme: #0f172a;
        }

        .font-hatil { font-family: 'Inter', sans-serif; }

        .reveal {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-card {
            background: white;
            border-radius: 3rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.03);
        }

        .input-hatil {
            border: 2px solid #f1f5f9;
            border-radius: 1.5rem;
            transition: all 0.3s ease;
            font-weight: 800;
            font-style: italic;
        }

        .input-hatil:focus {
            border-color: var(--dynamic-theme);
            ring: 0;
            box-shadow: 0 0 0 4px rgba(15, 23, 42, 0.05);
        }
    </style>

    <x-slot name="header">
        <div id="system-header-bg" class="w-full transition-all duration-500 rounded-b-[2.5rem] shadow-2xl bg-slate-900" 
             style="background-color: var(--dynamic-theme)">
            <div class="max-w-7xl mx-auto px-6 py-10">
                <div class="reveal flex flex-col md:flex-row justify-between items-center gap-6">
                    <div>
                        <nav class="flex mb-2 text-white/30 text-[10px] font-black uppercase tracking-[0.4em]">
                            <span>LOGÍSTICA</span> <span class="mx-2">/</span> <span>AJUSTE DE INVENTARIO</span>
                        </nav>
                        <h2 class="font-hatil font-black text-3xl text-white tracking-tighter italic uppercase">
                            Corregir <span class="text-white/40">Existencias</span>
                        </h2>
                    </div>
                    <div class="hidden md:block">
                        <span class="text-6xl opacity-20">🏭</span>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 min-h-screen font-hatil bg-[#f8fafc]">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="form-card p-10 reveal">
                {{-- Información del Mueble --}}
                <div class="mb-10 text-center">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-2">Producto Seleccionado</h3>
                    <h4 class="text-2xl font-black text-slate-900 italic uppercase tracking-tighter mb-1">
                        {{ $mueble->Nombre }}
                    </h4>
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-widest">SKU: {{ $mueble->SKU }}</p>
                </div>

                <div class="grid grid-cols-1 gap-6 mb-10">
                    <div class="bg-slate-50 rounded-[2rem] p-6 border border-slate-100 flex items-center justify-between">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Stock Actual</span>
                        <span class="text-2xl font-black italic @if($mueble->inventario->Cantidad < 5) text-red-500 @else text-slate-900 @endif">
                            {{ $mueble->inventario->Cantidad }} <small class="text-[10px] not-italic">Uds</small>
                        </span>
                    </div>
                </div>

                {{-- Errores --}}
                @if ($errors->any())
                    <div class="mb-6 p-5 bg-red-50 border border-red-100 rounded-[2rem]">
                        <ul class="text-[10px] font-black text-red-600 uppercase tracking-widest list-none">
                            @foreach ($errors->all() as $error)
                                <li>⚠️ {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.stock.update', $mueble->Mueble_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-8">
                        <label for="Cantidad" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 ml-2">
                            Ingresar Conteo Físico Total
                        </label>
                        <input type="number" name="Cantidad" id="Cantidad" 
                               value="{{ old('Cantidad', $mueble->inventario->Cantidad) }}"
                               required min="0"
                               class="input-hatil block w-full p-5 text-2xl text-slate-900">
                        
                        <div class="mt-4 p-4 bg-amber-50 rounded-2xl border border-amber-100 flex gap-3">
                            <span class="text-lg">⚡</span>
                            <p class="text-[9px] font-bold text-amber-700 uppercase tracking-widest leading-relaxed">
                                <b class="block">Atención:</b>
                                Este valor reemplazará el stock actual del sistema. Asegúrese de que el conteo sea exacto.
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center justify-end gap-4 mt-10">
                        <a href="{{ route('admin.stock.index') }}" 
                           class="w-full sm:w-auto text-center px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-slate-900 transition-colors">
                            Cancelar
                        </a>
                        
                        <button type="submit" 
                                class="w-full sm:w-auto px-10 py-4 bg-slate-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] italic shadow-xl shadow-slate-200 hover:scale-105 transition-transform"
                                style="background-color: var(--dynamic-theme)">
                            Actualizar Inventario
                        </button>
                    </div>
                </form>
            </div>

            {{-- Footer sutil --}}
            <p class="text-center mt-10 text-[9px] font-black text-slate-300 uppercase tracking-[0.5em]">
                Hatil Inventory Management System v2.0
            </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const themeColor = localStorage.getItem('hatil_theme_color') || '#0f172a';
            document.documentElement.style.setProperty('--dynamic-theme', themeColor);
            const header = document.getElementById('system-header-bg');
            if(header) header.style.backgroundColor = themeColor;
        });
    </script>
</x-app-layout>