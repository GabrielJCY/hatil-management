@props(['mueble'])

<div class="group relative bg-white rounded-[2.5rem] p-4 transition-all duration-500 hover:shadow-[0_30px_60px_-15px_rgba(0,0,0,0.1)] border border-transparent hover:border-gray-100 flex flex-col h-full">
    
    {{-- Contenedor de Imagen --}}
    <div class="relative aspect-square overflow-hidden rounded-[2rem] bg-[#f8f8f8]">
        {{-- Badge de Precio Flotante --}}
        <div class="absolute top-4 right-4 z-10">
            <span class="bg-white/90 backdrop-blur-md px-4 py-2 rounded-2xl text-xs font-black text-slate-900 shadow-sm border border-white/20">
                {{ number_format($mueble->Precio, 0) }} Bs
            </span>
        </div>

        <a href="{{ route('client.muebles.show', $mueble->Mueble_id) }}" class="block w-full h-full">
            <img src="{{ $mueble->Imagen ? asset('storage/' . $mueble->Imagen) : 'https://via.placeholder.com/400x400?text=HATIL' }}" 
                 alt="{{ $mueble->Nombre }}" 
                 class="w-full h-full object-cover transition-transform duration-700 cubic-bezier(0.16, 1, 0.3, 1) group-hover:scale-110">
        </a>
        
        {{-- Overlay al hacer Hover --}}
        <div class="absolute inset-0 bg-slate-900/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
    </div>

    {{-- Información del Producto --}}
    <div class="mt-6 px-2 flex flex-col flex-1">
        <div class="mb-3">
            <p class="text-[10px] font-black text-indigo-500 uppercase tracking-[0.2em] mb-1">
                {{ $mueble->categoria->Nombre ?? 'Colección Exclusiva' }}
            </p>
            <h3 class="text-xl font-black text-slate-900 tracking-tighter leading-tight italic">
                <a href="{{ route('client.muebles.show', $mueble->Mueble_id) }}" class="hover:text-indigo-600 transition-colors">
                    {{ $mueble->Nombre }}
                </a>
            </h3>
        </div>
        
        <p class="text-[11px] font-medium text-slate-400 line-clamp-2 mb-6 tracking-wide leading-relaxed">
            {{ $mueble->Descripcion }}
        </p>
        
        {{-- Botón de Acción Dinámico --}}
        <div class="mt-auto">
            <form action="{{ route('client.carrito.add', $mueble->Mueble_id) }}" method="POST" class="m-0">
                @csrf
                <button type="submit" 
                        class="btn-dynamic-theme w-full text-white py-4 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] flex items-center justify-center gap-3 transition-all active:scale-95 shadow-xl"
                        style="background-color: #0f172a;"> {{-- Color base que el JS cambiará --}}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Añadir al carrito
                </button>
            </form>
        </div>
    </div>
</div>