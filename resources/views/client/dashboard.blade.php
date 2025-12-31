<x-app-layout>
    <style>
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-card { animation: slideIn 0.8s ease-out forwards; }

        /* TRANSICIÓN NATURAL Y FLUIDA */
        .smooth-lift {
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }
        
        .smooth-lift:hover {
            transform: translateY(-12px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .transition-theme-all { 
            transition: background-color 0.8s cubic-bezier(0.4, 0, 0.2, 1), 
                        color 0.8s ease,
                        border-color 0.8s ease; 
        }

        /* Quitamos sombras y bordes por defecto del header original de Laravel */
        header { 
            background-color: transparent !important; 
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important; /* Importante para que nuestro fondo cubra todo */
        }
    </style>

    {{-- CABECERA DEL SISTEMA --}}
    <x-slot name="header">
        <div id="system-header-bg" class="w-full transition-theme-all rounded-b-[3rem] shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col md:flex-row items-center justify-between gap-4">
                <h2 id="header-title" class="font-black text-3xl text-white leading-tight uppercase tracking-tighter italic transition-theme-all">
                    {{ __('Mi Espacio') }} <span class="opacity-30">/</span> HATIL
                </h2>
                
                {{-- PALETA DE AMBIENTE --}}
                <div class="flex items-center gap-3 bg-white/10 backdrop-blur-md px-4 py-2 rounded-full border border-white/20">
                    <span class="text-[10px] font-black uppercase tracking-widest text-white/60 mr-1">Ambiente:</span>
                    <button onclick="changeTheme('#0f172a', '#f8fafc')" class="w-6 h-6 rounded-full bg-slate-900 border-2 border-white/50 hover:scale-110 transition-transform"></button>
                    <button onclick="changeTheme('#1e40af', '#eff6ff')" class="w-6 h-6 rounded-full bg-blue-800 border-2 border-white/50 hover:scale-110 transition-transform"></button>
                    <button onclick="changeTheme('#065f46', '#ecfdf5')" class="w-6 h-6 rounded-full bg-emerald-800 border-2 border-white/50 hover:scale-110 transition-transform"></button>
                    <button onclick="changeTheme('#991b1b', '#fef2f2')" class="w-6 h-6 rounded-full bg-red-800 border-2 border-white/50 hover:scale-110 transition-transform"></button>
                    <button onclick="changeTheme('#6b21a8', '#faf5ff')" class="w-6 h-6 rounded-full bg-purple-800 border-2 border-white/50 hover:scale-110 transition-transform"></button>
                </div>
            </div>
        </div>
    </x-slot>

    <div id="main-wrapper" class="py-12 transition-theme-all min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-10 animate-card">
                <div class="flex items-baseline gap-2">
                    <h1 class="text-4xl font-black text-slate-900 tracking-tighter transition-theme-all" id="welcome-text">
                        Hola, {{ explode(' ', Auth::user()->name)[0] }}
                    </h1>
                    <div id="theme-dot" class="h-3 w-3 rounded-full bg-slate-900 transition-theme-all"></div>
                </div>
            </div>

            {{-- GRILLA DE CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12 animate-card" style="animation-delay: 0.2s">
                <a href="{{ route('client.carrito.index') }}" id="card-cart" class="group relative bg-slate-900 p-8 rounded-[2rem] shadow-xl smooth-lift overflow-hidden">
                    <div class="absolute -right-4 -bottom-4 text-white/10 transition-opacity duration-700 group-hover:opacity-30">
                        <svg class="h-32 w-32" fill="currentColor" viewBox="0 0 24 24"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/></svg>
                    </div>
                    <div class="relative z-10">
                        <div class="h-14 w-14 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center mb-6 border border-white/20 shadow-lg">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        </div>
                        <h4 class="text-xl font-black text-white uppercase tracking-tighter">Mi Carrito</h4>
                        <p class="text-white/40 text-[10px] font-black mt-2 uppercase tracking-[0.2em]">Finalizar compra</p>
                    </div>
                </a>

                <a href="{{ route('profile.edit') }}" id="card-profile" class="group relative bg-slate-900 p-8 rounded-[2rem] shadow-xl smooth-lift overflow-hidden">
                    <div class="absolute -right-4 -bottom-4 text-white/10 transition-opacity duration-700 group-hover:opacity-30">
                        <svg class="h-32 w-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    </div>
                    <div class="relative z-10">
                        <div class="h-14 w-14 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center mb-6 border border-white/20 shadow-lg">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <h4 class="text-xl font-black text-white uppercase tracking-tighter">Mi Perfil</h4>
                        <p class="text-white/40 text-[10px] font-black mt-2 uppercase tracking-[0.2em]">Ajustes de cuenta</p>
                    </div>
                </a>

                <a href="{{ route('client.catalogo.index') }}" id="card-catalog" class="group relative bg-slate-900 p-8 rounded-[2rem] shadow-xl smooth-lift overflow-hidden">
                    <div class="absolute -right-4 -bottom-4 text-white/10 transition-opacity duration-700 group-hover:opacity-30">
                        <svg class="h-32 w-32" fill="currentColor" viewBox="0 0 24 24"><path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/></svg>
                    </div>
                    <div class="relative z-10">
                        <div class="h-14 w-14 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center mb-6 border border-white/20 shadow-lg">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                        </div>
                        <h4 class="text-xl font-black text-white uppercase tracking-tighter">Catálogo</h4>
                        <p class="text-white/40 text-[10px] font-black mt-2 uppercase tracking-[0.2em]">Nuevos Ingresos</p>
                    </div>
                </a>
            </div>

            {{-- FOOTER --}}
            <div id="footer-banner" class="bg-slate-900 rounded-[2.5rem] p-10 flex flex-col md:flex-row items-center justify-between shadow-2xl animate-card transition-theme-all">
                <div class="text-white text-center md:text-left">
                    <h3 class="text-2xl font-black tracking-tighter italic uppercase">Asistencia HATIL</h3>
                    <p class="text-white/40 text-sm font-bold mt-1 uppercase tracking-widest">Soporte VIP disponible</p>
                </div>
                <a href="#" class="bg-white text-slate-900 px-10 py-4 rounded-2xl font-black uppercase text-xs tracking-widest shadow-lg hover:bg-slate-200 smooth-lift">
                    Contactar ahora
                </a>
            </div>
        </div>
    </div>

    <script>
        function changeTheme(primaryColor, bgColor) {
            localStorage.setItem('hatil_theme_color', primaryColor);
            localStorage.setItem('hatil_bg_color', bgColor);
            applyTheme(primaryColor, bgColor);
        }

        function applyTheme(color, bgColor) {
            const wrapper = document.getElementById('main-wrapper');
            if (wrapper) wrapper.style.backgroundColor = bgColor;

            // Elementos que adoptan el color primario como FONDO
            const darkElements = [
                'system-header-bg', 
                'card-cart', 
                'card-profile', 
                'card-catalog', 
                'footer-banner', 
                'theme-dot'
            ];
            
            darkElements.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.style.backgroundColor = color;
            });

            // Elementos que adoptan el color primario como TEXTO
            const welcomeText = document.getElementById('welcome-text');
            if (welcomeText) welcomeText.style.color = color;
        }

        // Aplicar el tema guardado al cargar la página
        document.addEventListener('DOMContentLoaded', () => {
            const savedColor = localStorage.getItem('hatil_theme_color') || '#0f172a';
            const savedBg = localStorage.getItem('hatil_bg_color') || '#f8fafc';
            applyTheme(savedColor, savedBg);
        });
    </script>
</x-app-layout>