<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800;900&display=swap');

        :root {
            --dynamic-theme: #0f172a;
            --dynamic-bg: #f8fafc;
        }

        .font-hatil { font-family: 'Inter', sans-serif; }

        .transition-all-custom {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .reveal {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .theme-dot {
            width: 14px; height: 14px; border-radius: 50%; cursor: pointer;
            transition: transform 0.2s; border: 2px solid white;
        }
        .theme-dot:hover { transform: scale(1.3); }

        /* Estilo fiel a tu imagen image_db1fb5.png */
        .tool-card {
            background-color: #ffffff;
            transition: all 0.4s ease;
            border: 1px solid #f1f5f9;
        }

        .tool-card:hover {
            background-color: var(--dynamic-theme) !important;
            transform: translateY(-5px);
            border-color: transparent;
        }

        .tool-card:hover p { color: #ffffff !important; }
        
        /* Efecto para que el emoji/icono resalte en hover */
        .tool-card:hover .icon-span { transform: scale(1.2); display: inline-block; }

        .kpi-card:hover {
            border-color: var(--dynamic-theme);
            box-shadow: 0 10px 20px -10px rgba(0,0,0,0.1);
        }
    </style>

    <x-slot name="header">
        <div id="system-header-bg" class="w-full transition-all-custom rounded-b-[2.5rem] shadow-2xl">
            <div class="max-w-7xl mx-auto px-6 py-10">
                <div class="reveal flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div>
                        <nav class="flex mb-2 text-white/30 text-[10px] font-black uppercase tracking-[0.4em]">
                            <span>HATIL MANAGEMENT</span> <span class="mx-2">/</span> <span>DASHBOARD</span>
                        </nav>
                        <h2 class="font-hatil font-black text-4xl text-white tracking-tighter italic uppercase">
                            Panel <span class="text-white/40">Administrativo</span>
                        </h2>
                    </div>
                    
                    <div class="bg-white/10 p-4 rounded-3xl backdrop-blur-md border border-white/10">
                        <p class="text-[9px] font-black text-white/40 uppercase mb-3 tracking-widest text-center">Personalizar Tema</p>
                        <div class="flex gap-3">
                            <div onclick="updateTheme('#0f172a', '#f8fafc')" class="theme-dot bg-slate-900"></div>
                            <div onclick="updateTheme('#1e40af', '#eff6ff')" class="theme-dot bg-blue-700"></div>
                            <div onclick="updateTheme('#065f46', '#ecfdf5')" class="theme-dot bg-emerald-800"></div>
                            <div onclick="updateTheme('#7f1d1d', '#fef2f2')" class="theme-dot bg-red-900"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div id="main-wrapper" class="py-12 min-h-screen transition-all-custom font-hatil">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- 📊 KPIs Superiores --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12 reveal">
                @php
                    $cards = [
                        ['title' => 'Pedidos Totales', 'val' => $kpis['pedidos'] ?? '0', 'icon' => '📝'],
                        ['title' => 'Ingresos Totales', 'val' => number_format($kpis['pagos_total'] ?? 0, 0).' Bs', 'icon' => '💰'],
                        ['title' => 'Staff Activo', 'val' => $kpis['empleados'] ?? '0', 'icon' => '👥'],
                        ['title' => 'Usuarios Vips', 'val' => $kpis['usuarios'] ?? '0', 'icon' => '💎']
                    ];
                @endphp

                @foreach ($cards as $card)
                <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-transparent kpi-card transition-all group">
                    <div class="flex justify-between items-start mb-4">
                        <span class="text-2xl">{{ $card['icon'] }}</span>
                        <span class="text-[9px] font-black text-slate-400 bg-slate-50 px-2 py-1 rounded-md uppercase">Live</span>
                    </div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $card['title'] }}</p>
                    <h3 class="text-2xl font-black text-slate-900 italic tracking-tighter">{{ $card['val'] }}</h3>
                </div>
                @endforeach
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- 🛠️ COLUMNA IZQUIERDA: HERRAMIENTAS (Incluyendo STOCK) --}}
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white rounded-[3rem] p-8 shadow-xl reveal">
                        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-8 px-2">Herramientas de Gestión</h4>
                        
                        {{-- Cuadrícula de herramientas --}}
                        <div class="grid grid-cols-2 gap-4">
                            @php
                                $tools = [
                                    ['route' => 'admin.users.index', 'name' => 'Usuarios', 'icon' => '👤'],
                                    ['route' => 'admin.pedidos.index', 'name' => 'Pedidos', 'icon' => '📝'],
                                    ['route' => 'admin.pagos.index', 'name' => 'Pagos', 'icon' => '💳'],
                                    ['route' => 'admin.muebles.index', 'name' => 'Muebles', 'icon' => '🛍️'],
                                    ['route' => 'admin.categorias.index', 'name' => 'Categorías', 'icon' => '🏷️'],
                                    ['route' => 'admin.proveedores.index', 'name' => 'Proveedores', 'icon' => '🚚'],
                                    ['route' => 'admin.stock.index', 'name' => 'Stock', 'icon' => '🏭'], // BOTÓN SOLICITADO
                                ];
                            @endphp
                            
                            @foreach($tools as $tool)
                            <a href="{{ route($tool['route']) }}" class="tool-card p-8 rounded-[2.5rem] text-center group">
                                <span class="block text-3xl mb-3 icon-span transition-transform">{{ $tool['icon'] }}</span>
                                <p class="text-[10px] font-black uppercase text-slate-800 tracking-tighter">{{ $tool['name'] }}</p>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- 🕒 COLUMNA DERECHA: MOVIMIENTOS Y PAGOS --}}
                <div class="lg:col-span-2 space-y-8">
                    
                    {{-- ÚLTIMOS MOVIMIENTOS --}}
                    <div class="bg-white rounded-[3rem] p-10 shadow-xl reveal">
                        <div class="flex justify-between items-center mb-8">
                            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Últimos Movimientos</h3>
                            <a href="{{ route('admin.pedidos.index') }}" class="text-[10px] font-black text-slate-900 hover:underline uppercase italic">Ver todos</a>
                        </div>
                        <div class="overflow-hidden">
                            <table class="w-full text-left">
                                <tbody class="divide-y divide-slate-100">
                                    @foreach ($pedidosRecientes as $pedido)
                                    <tr class="group hover:bg-slate-50 transition-colors">
                                        <td class="py-5">
                                            <p class="text-xs font-black text-slate-900 italic uppercase">ID #{{ $pedido->Pedido_id }}</p>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase">{{ $pedido->usuario->name ?? 'Cliente' }}</p>
                                        </td>
                                        <td class="py-5 text-right">
                                            <span class="text-[9px] font-black uppercase px-4 py-1.5 rounded-full bg-slate-100 text-slate-600 group-hover:bg-white group-hover:shadow-sm">
                                                {{ $pedido->Estado }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- VERIFICACIÓN DE PAGOS --}}
                    <div id="payment-status-card" class="rounded-[3rem] p-10 shadow-2xl text-white reveal transition-all-custom">
                        <div class="flex justify-between items-center mb-8">
                            <h3 class="text-[10px] font-black text-white/30 uppercase tracking-[0.4em]">Verificación de Pagos</h3>
                        </div>
                        <div class="space-y-4">
                            @forelse ($pagosPendientes as $pago)
                            <div class="flex items-center justify-between p-5 bg-white/5 rounded-3xl border border-white/5 hover:bg-white/10 transition-all">
                                <div>
                                    <p class="text-[10px] font-black text-white/40 uppercase mb-1">Transacción #{{ $pago->Pago_id }}</p>
                                    <p class="text-lg font-black italic tracking-tighter">{{ number_format($pago->Monto, 0) }} Bs</p>
                                </div>
                                <a href="{{ route('admin.pagos.edit', $pago) }}" class="bg-white text-slate-900 text-[9px] font-black uppercase px-6 py-2.5 rounded-xl shadow-lg">Revisar</a>
                            </div>
                            @empty
                            <p class="text-center py-4 text-white/20 italic">Sin pagos pendientes</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateTheme(color, bgColor) {
            localStorage.setItem('hatil_theme_color', color);
            localStorage.setItem('hatil_bg_color', bgColor);
            
            document.documentElement.style.setProperty('--dynamic-theme', color);
            document.documentElement.style.setProperty('--dynamic-bg', bgColor);

            const header = document.getElementById('system-header-bg');
            const wrapper = document.getElementById('main-wrapper');
            const paymentCard = document.getElementById('payment-status-card');
            
            if(header) header.style.backgroundColor = color;
            if(paymentCard) paymentCard.style.backgroundColor = color;
            if(wrapper) wrapper.style.backgroundColor = bgColor;
        }

        document.addEventListener('DOMContentLoaded', () => {
            const c = localStorage.getItem('hatil_theme_color') || '#0f172a';
            const b = localStorage.getItem('hatil_bg_color') || '#f8fafc';
            updateTheme(c, b);
        });
    </script>
</x-app-layout>