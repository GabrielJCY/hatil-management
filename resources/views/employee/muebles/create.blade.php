{{-- resources/views/employee/muebles/create.blade.php --}}
<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800;900&display=swap');
        .font-hatil { font-family: 'Inter', sans-serif; }
        .label-tiny { font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.2em; color: #94a3b8; display: block; margin-bottom: 0.75rem; }
        .input-hatil { width: 100%; background-color: #f8fafc; border: 2px solid #f1f5f9; border-radius: 1.25rem; padding: 1rem 1.25rem; font-size: 13px; font-weight: 700; color: #1e293b; transition: all 0.3s; }
        .input-hatil:focus { outline: none; border-color: #0f172a; background-color: #fff; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); }
        .reveal { animation: fadeInUp 0.5s ease-out forwards; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        
        /* Estilo para el área de carga de imagen */
        .image-dropzone { border: 2px dashed #e2e8f0; border-radius: 2rem; transition: all 0.3s; cursor: pointer; background: #fcfcfc; position: relative; min-height: 250px; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .image-dropzone:hover { border-color: #0f172a; background: #f8fafc; }
    </style>

    <x-slot name="header">
        <div class="w-full rounded-b-[4rem] shadow-2xl bg-slate-900 overflow-hidden">
            <div class="max-w-7xl mx-auto px-6 py-12 reveal">
                <nav class="flex mb-3 text-white/30 text-[10px] font-black uppercase tracking-[0.5em]">
                    <span>INVENTARIO</span> <span class="mx-2">/</span> <span>NUEVO MUEBLE</span>
                </nav>
                <h2 class="font-hatil font-black text-4xl text-white tracking-tighter italic uppercase leading-none">
                    Registrar <span class="text-white/40">Mueble HATIL</span>
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen font-hatil">
        <div class="max-w-6xl mx-auto px-6 lg:px-8">
            
            {{-- ERRORES DE VALIDACIÓN --}}
            @if ($errors->any())
                <div class="mb-8 p-6 bg-red-50 border-l-4 border-red-500 rounded-2xl reveal">
                    <h3 class="text-xs font-black text-red-800 uppercase tracking-widest mb-2">Errores detectados</h3>
                    <ul class="text-xs text-red-700 font-bold list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.muebles.store') }}" enctype="multipart/form-data" class="reveal">
                @csrf 

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    {{-- COLUMNA IZQUIERDA: IMAGEN Y ESTADO --}}
                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-white p-8 rounded-[3rem] shadow-sm border border-slate-100 text-center">
                            <span class="label-tiny">Fotografía del Mueble</span>
                            
                            <div class="image-dropzone mb-4" id="dropzone">
                                <img id="preview" src="" class="hidden absolute inset-0 w-full h-full object-cover z-20 pointer-events-none">
                                
                                <div id="dropzone-content" class="relative z-10">
                                    <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Subir Imagen</p>
                                </div>
                                
                                <input type="file" name="imagen" id="imagen-input" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-30" accept="image/*" required onchange="previewImage(event)">
                            </div>

                            <button type="button" id="remove-photo" class="hidden text-[9px] font-black text-red-500 uppercase tracking-widest hover:underline">
                                × Quitar fotografía
                            </button>
                        </div>

                        <div class="bg-white p-8 rounded-[3rem] shadow-sm border border-slate-100">
                            <span class="label-tiny">Estado</span>
                            <input type="text" name="estado" value="{{ old('estado') ?? 'Disponible' }}" class="input-hatil" required>
                        </div>
                    </div>

                    {{-- COLUMNA DERECHA: DATOS DEL FORMULARIO --}}
                    <div class="lg:col-span-2 bg-white p-10 rounded-[4rem] shadow-sm border border-slate-100">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div class="md:col-span-2">
                                <span class="label-tiny">Nombre del Producto</span>
                                <input type="text" name="nombre" value="{{ old('nombre') }}" class="input-hatil" required autofocus placeholder="Ej: Sofá Minimalista de Lujo">
                            </div>

                            <div>
                                <span class="label-tiny">Categoría</span>
                                <select name="categoria_id" class="input-hatil" required>
                                    <option value="">Selecciona una Categoría</option>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->Categoria_id }}" @selected(old('categoria_id') == $categoria->Categoria_id)>
                                            {{ $categoria->Nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <span class="label-tiny">Proveedor</span>
                                <select name="proveedor_id" class="input-hatil" required>
                                    <option value="">Selecciona un Proveedor</option>
                                    @foreach ($proveedores as $proveedor)
                                        <option value="{{ $proveedor->Proveedor_id }}" @selected(old('proveedor_id') == $proveedor->Proveedor_id)>
                                            {{ $proveedor->Nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <span class="label-tiny">Material</span>
                                <input type="text" name="material" value="{{ old('material') }}" class="input-hatil" required placeholder="Ej: Madera de Cedro">
                            </div>

                            <div>
                                <span class="label-tiny">Color</span>
                                <input type="text" name="color" value="{{ old('color') }}" class="input-hatil" required placeholder="Ej: Negro Mate">
                            </div>

                            <div>
                                <span class="label-tiny">Precio (Bs.)</span>
                                <input type="number" step="0.01" min="0" name="precio" value="{{ old('precio') }}" class="input-hatil" required placeholder="0.00">
                            </div>

                            <div>
                                <span class="label-tiny">Dimensiones</span>
                                <input type="text" name="dimensiones" value="{{ old('dimensiones') }}" class="input-hatil" required placeholder="120x80x50 cm">
                            </div>

                            <div class="md:col-span-2">
                                <span class="label-tiny">Descripción</span>
                                <textarea name="descripcion" rows="4" class="input-hatil" style="border-radius: 1.5rem;" required placeholder="Describe las características y acabados del mueble...">{{ old('descripcion') }}</textarea>
                            </div>
                        </div>

                        <div class="mt-12 pt-8 border-t border-slate-50 flex items-center justify-between">
                            <a href="{{ route('admin.muebles.index') }}" class="text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-slate-900 transition-all italic">
                                ← Volver al Catálogo
                            </a>
                            <button type="submit" class="bg-slate-900 text-white px-12 py-5 rounded-[2rem] text-[10px] font-black uppercase tracking-[0.3em] shadow-2xl hover:bg-slate-800 transition-all italic hover:-translate-y-1">
                                Guardar Registro
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- SCRIPTS PARA PREVISUALIZACIÓN --}}
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            const preview = document.getElementById('preview');
            const content = document.getElementById('dropzone-content');
            const removeBtn = document.getElementById('remove-photo');
            const dropzone = document.getElementById('dropzone');

            reader.onload = function() {
                if (reader.readyState === 2) {
                    preview.src = reader.result;
                    preview.classList.remove('hidden');
                    content.classList.add('opacity-0');
                    removeBtn.classList.remove('hidden');
                    dropzone.style.borderStyle = 'solid';
                    dropzone.classList.add('border-slate-900');
                }
            }

            if (event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }

        document.getElementById('remove-photo').addEventListener('click', function() {
            const input = document.getElementById('imagen-input');
            const preview = document.getElementById('preview');
            const content = document.getElementById('dropzone-content');
            const dropzone = document.getElementById('dropzone');
            
            input.value = "";
            preview.src = "";
            preview.classList.add('hidden');
            content.classList.remove('opacity-0');
            this.classList.add('hidden');
            dropzone.style.borderStyle = 'dashed';
            dropzone.classList.remove('border-slate-900');
        });
    </script>
</x-app-layout>