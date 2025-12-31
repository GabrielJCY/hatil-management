<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap');
        
        .transition-theme-all {
            transition: background-color 0.6s cubic-bezier(0.4, 0, 0.2, 1), 
                        color 0.6s ease, 
                        border-color 0.6s ease,
                        box-shadow 0.6s ease;
        }

        .custom-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1.5em 1.5em;
        }

        .reveal {
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        header { background: transparent !important; box-shadow: none !important; padding: 0 !important; }
        
        /* Ajuste para que las tarjetas resalten en fondos oscuros */
        .product-card-container {
            backdrop-blur: 10px;
        }
    </style>

    <x-slot name="header">
        <div id="system-header-bg" class="w-full transition-theme-all rounded-b-[3rem] shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="reveal">
                        <nav class="flex mb-2 text-white/40 text-[10px] font-black uppercase tracking-[0.3em]">
                            <span>HATIL</span> <span class="mx-2 text-white/20">/</span> <span>MUEBLES</span>
                        </nav>
                        <h2 class="font-black text-4xl text-white leading-tight uppercase tracking-tighter italic">
                            Nuestro <span class="opacity-40">Catálogo</span>
                        </h2>
                    </div>
                    
                    {{-- PALETA CON COLORES DE FONDO FUERTES --}}
                    <div class="flex items-center gap-3 bg-black/20 backdrop-blur-xl px-4 py-2 rounded-full border border-white/10 shadow-2xl">
                        <button title="Noche" onclick="changeTheme('#0f172a', '#020617')" class="w-6 h-6 rounded-full bg-slate-900 border-2 border-white/30 hover:scale-125 transition-transform"></button>
                        <button title="Océano" onclick="changeTheme('#1e40af', '#1e3a8a')" class="w-6 h-6 rounded-full bg-blue-800 border-2 border-white/30 hover:scale-125 transition-transform"></button>
                        <button title="Bosque" onclick="changeTheme('#065f46', '#064e3b')" class="w-6 h-6 rounded-full bg-emerald-800 border-2 border-white/30 hover:scale-125 transition-transform"></button>
                        <button title="Vino" onclick="changeTheme('#991b1b', '#450a0a')" class="w-6 h-6 rounded-full bg-red-800 border-2 border-white/30 hover:scale-125 transition-transform"></button>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div id="main-wrapper" class="py-12 transition-theme-all min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                
                <aside class="md:col-span-1 reveal">
                    <div class="bg-white/90 backdrop-blur-md p-8 rounded-[2rem] shadow-2xl border border-white/20 sticky top-10">
                        <h2 class="text-xs font-black text-slate-500 uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                            Filtrar
                        </h2>
                        
                        <form action="{{ route('client.catalogo.index') }}" method="GET">
                            <div class="mb-8">
                                <label class="block text-[10px] font-black text-slate-700 uppercase tracking-widest mb-3">Categoría</label>
                                <select name="categoria" class="custom-select mt-1 block w-full rounded-2xl border-gray-200 bg-gray-50 py-3 px-4 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-slate-900 transition-all">
                                    <option value="">Todas las piezas</option>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->Categoria_id }}" {{ request('categoria') == $categoria->Categoria_id ? 'selected' : '' }}>
                                            {{ $categoria->Nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <button type="submit" id="btn-theme-action" class="w-full py-4 px-6 rounded-2xl text-[10px] font-black uppercase tracking-widest text-white transition-theme-all shadow-xl hover:brightness-110">
                                Aplicar Filtros
                            </button>
                        </form>
                    </div>
                </aside>

                <main class="md:col-span-3 reveal" style="animation-delay: 0.2s">
                    @if ($muebles->isEmpty())
                        <div class="p-20 bg-black/10 backdrop-blur-md rounded-[3rem] border-2 border-dashed border-white/10 text-center">
                            <p id="empty-text" class="text-sm font-bold text-white/50 uppercase tracking-widest transition-theme-all">No hay muebles disponibles.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach ($muebles as $mueble)
                                <x-catalog.product-card :mueble="$mueble" />
                            @endforeach
                        </div>
                        <div class="mt-16 bg-white/5 p-4 rounded-3xl backdrop-blur-sm">
                            {{ $muebles->appends(request()->query())->links() }}
                        </div>
                    @endif
                </main>
            </div>
        </div>
    </div>

    @if (session('status') === 'HECHO')
        <div id="modal-success" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/80 backdrop-blur-md p-4">
            <div class="bg-white p-10 rounded-[3rem] shadow-2xl text-center max-w-sm w-full border border-gray-100">
                <div class="mx-auto mb-6 flex items-center justify-center h-20 w-20 rounded-full bg-emerald-100 text-3xl">✅</div>
                <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tighter mb-2 italic">¡PEDIDO HECHO!</h2>
                <p class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-8">Tu compra se ha procesado con éxito.</p>
                <button onclick="document.getElementById('modal-success').remove()" id="btn-modal-theme" class="w-full text-white font-black uppercase text-[10px] tracking-[0.2em] py-4 rounded-2xl transition-all shadow-lg">
                    Aceptar
                </button>
            </div>
        </div>
    @endif

    <script>
        function changeTheme(primaryColor, bgColor) {
            localStorage.setItem('hatil_theme_color', primaryColor);
            localStorage.setItem('hatil_bg_color', bgColor);
            applyTheme(primaryColor, bgColor);
        }

        function applyTheme(color, bgColor) {
            // 1. Fondo de la página (Fondo Fuerte)
            const wrapper = document.getElementById('main-wrapper');
            if (wrapper) wrapper.style.backgroundColor = bgColor;

            // 2. Fondo del Encabezado
            const headerBg = document.getElementById('system-header-bg');
            if (headerBg) headerBg.style.backgroundColor = color;

            // 3. Botón de Filtros
            const btnAction = document.getElementById('btn-theme-action');
            if (btnAction) {
                btnAction.style.backgroundColor = color;
                btnAction.style.boxShadow = `0 15px 30px -5px ${color}60`;
            }

            // 4. Botón del Modal
            const btnModal = document.getElementById('btn-modal-theme');
            if (btnModal) btnModal.style.backgroundColor = color;

            // 5. TODOS LOS BOTONES DE PRODUCTOS
            const dynamicButtons = document.querySelectorAll('.btn-dynamic-theme');
            dynamicButtons.forEach(btn => {
                btn.style.setProperty('background-color', color, 'important');
                btn.style.boxShadow = `0 10px 25px -5px ${color}80`; 
            });

            // 6. Texto de "No hay muebles" (para que sea blanco en fondos fuertes)
            const emptyText = document.getElementById('empty-text');
            if (emptyText) emptyText.style.color = 'rgba(255, 255, 255, 0.6)';
        }

        document.addEventListener('DOMContentLoaded', () => {
            const savedColor = localStorage.getItem('hatil_theme_color') || '#0f172a';
            const savedBg = localStorage.getItem('hatil_bg_color') || '#020617';
            applyTheme(savedColor, savedBg);
        });
    </script>
</x-app-layout>