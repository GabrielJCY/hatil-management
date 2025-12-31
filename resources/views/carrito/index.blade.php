<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap');

        .transition-theme-all {
            transition: background 0.8s cubic-bezier(0.4, 0, 0.2, 1), 
                        color 0.6s ease,
                        box-shadow 0.6s ease;
        }

        .reveal {
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        header { background: transparent !important; box-shadow: none !important; padding: 0 !important; }
        
        /* Evita flechas en input number */
        input::-webkit-outer-spin-button, input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    </style>

    {{-- NOTIFICACIÓN FLOTANTE REFORZADA (GLASSMORPHISM DE ALTO CONTRASTE) --}}
    @if (session('status') || session('success'))
        <div id="status-toast" class="reveal fixed top-10 left-1/2 -translate-x-1/2 z-[100] w-full max-w-md px-4">
            <div class="bg-slate-900/90 backdrop-blur-3xl border-2 border-white/30 rounded-[2.5rem] p-6 shadow-[0_30px_60px_-15px_rgba(0,0,0,0.9)] flex items-center gap-5 border-l-[12px] border-l-emerald-500">
                
                {{-- Icono con brillo --}}
                <div class="flex-shrink-0 w-12 h-12 bg-emerald-500/30 rounded-full flex items-center justify-center text-emerald-400 shadow-[0_0_20px_rgba(16,185,129,0.5)]">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>

                <div class="flex-1">
                    <p class="text-[10px] font-black text-emerald-400 uppercase tracking-[0.3em] mb-1">Confirmado</p>
                    <p class="text-base font-bold text-white tracking-tight uppercase italic leading-tight drop-shadow-lg">
                        {{ session('status') ?? session('success') }}
                    </p>
                </div>

                {{-- Botón de cierre --}}
                <button onclick="closeToast()" class="bg-white/10 hover:bg-white/20 p-2 rounded-full text-white transition-all active:scale-90">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <script>
            function closeToast() {
                const toast = document.getElementById('status-toast');
                if(toast) {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translate(-50%, -30px) scale(0.95)';
                    setTimeout(() => toast.remove(), 600);
                }
            }
            // 5 segundos para asegurar visibilidad
            setTimeout(closeToast, 5000);
        </script>
    @endif

    <x-slot name="header">
        <div id="system-header-bg" class="w-full transition-theme-all rounded-b-[3rem] shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
                <div class="reveal">
                    <nav class="flex mb-2 text-white/40 text-[10px] font-black uppercase tracking-[0.3em]">
                        <span>HATIL</span> <span class="mx-2 text-white/20">/</span> <span>SHOPPING CART</span>
                    </nav>
                    <h2 class="font-black text-4xl text-white leading-tight uppercase tracking-tighter italic">
                        Tu Selección <span class="opacity-40 text-2xl block md:inline md:ml-2">Exclusiva</span>
                    </h2>
                </div>
            </div>
        </div>
    </x-slot>

    <div id="main-wrapper" class="py-12 transition-theme-all min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if (empty($carrito) || count($carrito['items']) === 0)
                <div class="max-w-2xl mx-auto bg-white/5 backdrop-blur-xl rounded-[4rem] p-24 text-center border border-white/10 reveal">
                    <div class="text-7xl mb-8 opacity-50">🛒</div>
                    <h2 class="text-2xl font-black text-white italic tracking-tighter mb-4 uppercase">El carrito está vacío</h2>
                    <p class="text-sm font-bold text-white/40 uppercase tracking-widest mb-12">No dejes pasar la oportunidad de renovar tu espacio.</p>
                    <a href="{{ route('client.catalogo.index') }}" 
                       class="btn-dynamic-theme inline-block px-12 py-5 rounded-2xl text-[10px] font-black uppercase tracking-[0.3em] text-white shadow-2xl transition-all hover:scale-105">
                        Volver al Catálogo
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                    
                    {{-- PRODUCTOS --}}
                    <div class="lg:col-span-2 space-y-6 reveal">
                        <div class="flex items-center justify-between px-8 mb-4">
                            <h3 class="text-[10px] font-black text-white/50 uppercase tracking-[0.3em]">Lista de Artículos</h3>
                            <span class="text-[10px] font-black text-white/20 uppercase tracking-widest">{{ count($carrito['items']) }} Unidades</span>
                        </div>

                        @foreach ($carrito['items'] as $item)
                            <div class="group bg-white rounded-[3rem] p-8 flex flex-col md:flex-row items-center gap-8 border border-white/20 transition-all duration-500 shadow-xl hover:shadow-2xl">
                                
                                <div class="w-36 h-36 rounded-[2rem] overflow-hidden bg-gray-50 flex-shrink-0 shadow-inner">
                                    <img src="{{ $item['mueble']->Imagen ? asset('storage/' . $item['mueble']->Imagen) : 'https://via.placeholder.com/400x400?text=HATIL' }}" 
                                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                </div>

                                <div class="flex-1 text-center md:text-left">
                                    <p class="text-[9px] font-black text-indigo-500 uppercase tracking-[0.2em] mb-2">{{ $item['mueble']->categoria->Nombre ?? 'HATIL SELECTION' }}</p>
                                    <h3 class="text-2xl font-black text-slate-900 italic tracking-tighter leading-none mb-2">{{ $item['mueble']->Nombre }}</h3>
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">P. Unitario: {{ number_format($item['mueble']->Precio, 0) }} Bs</p>
                                </div>

                                <div class="flex items-center gap-8">
                                    <form action="{{ route('client.carrito.update', $item['mueble']->Mueble_id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="number" name="cantidad" value="{{ $item['cantidad'] }}" min="1" 
                                               onchange="this.form.submit()" 
                                               class="w-16 rounded-2xl border-none bg-slate-100 text-center py-3 text-sm font-black text-slate-900 focus:ring-2 focus:ring-slate-400 transition-all">
                                    </form>
                                    
                                    <div class="text-right min-w-[120px]">
                                        <p class="text-2xl font-black text-slate-900 tracking-tighter">{{ number_format($item['subtotal'], 0) }} Bs</p>
                                    </div>

                                    <form action="{{ route('client.carrito.remove', $item['mueble']->Mueble_id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-12 h-12 flex items-center justify-center rounded-2xl bg-red-50 text-red-300 hover:bg-red-500 hover:text-white transition-all duration-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- RESUMEN --}}
                    <div class="lg:col-span-1 reveal" style="animation-delay: 0.2s">
                        <div class="bg-white p-10 rounded-[4rem] shadow-2xl border border-white/10">
                            <h2 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-10">Resumen de Orden</h2>
                            
                            <div class="space-y-5 mb-10">
                                <div class="flex justify-between text-sm font-bold text-slate-500">
                                    <span class="uppercase tracking-widest text-[10px]">Subtotal</span>
                                    <span>{{ number_format($carrito['subtotal_general'], 0) }} Bs</span>
                                </div>
                                <div class="flex justify-between text-sm font-bold">
                                    <span class="uppercase tracking-widest text-[10px] text-slate-500">Envío</span>
                                    <span class="text-emerald-500 italic font-black">GRATIS</span>
                                </div>
                                <div class="h-[1px] bg-slate-100 my-6"></div>
                                <div class="flex justify-between items-end">
                                    <span class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Total</span>
                                    <span class="text-4xl font-black text-slate-900 tracking-tighter italic leading-none">{{ number_format($carrito['total_general'], 0) }} Bs</span>
                                </div>
                            </div>

                            <a href="{{ route('client.checkout') }}" id="btn-theme-action"
                               class="btn-dynamic-theme w-full flex items-center justify-center py-6 rounded-[2rem] text-[10px] font-black uppercase tracking-[0.3em] text-white shadow-xl transition-all active:scale-95">
                                Proceder al Pago <svg class="w-4 h-4 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function applyTheme(color, bgColor) {
            const wrapper = document.getElementById('main-wrapper');
            if (wrapper) {
                // Suavizado extremo del fondo
                wrapper.style.background = `linear-gradient(165deg, ${bgColor} 0%, ${color}08 100%)`;
            }

            const headerBg = document.getElementById('system-header-bg');
            if (headerBg) headerBg.style.backgroundColor = color;

            const dynamicButtons = document.querySelectorAll('.btn-dynamic-theme');
            dynamicButtons.forEach(btn => {
                btn.style.setProperty('background-color', color, 'important');
                btn.style.boxShadow = `0 20px 40px -10px ${color}50`; 
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            const savedColor = localStorage.getItem('hatil_theme_color') || '#0f172a';
            const savedBg = localStorage.getItem('hatil_bg_color') || '#020617';
            applyTheme(savedColor, savedBg);
        });
    </script>
</x-app-layout>