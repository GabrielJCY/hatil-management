<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800;900&display=swap');

        :root {
            --dynamic-theme: #0f172a;
            --dynamic-bg: #f8fafc;
        }

        .font-hatil { font-family: 'Inter', sans-serif; }

        .reveal {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Estilo de tabla moderna */
        .user-table { border-collapse: separate; border-spacing: 0 12px; }
        
        .user-row {
            background-color: white;
            transition: all 0.3s ease;
        }

        .user-row:hover {
            transform: scale(1.01);
            box-shadow: 0 10px 25px -10px rgba(0,0,0,0.1);
        }

        /* Botón que hereda el color de la paleta */
        .btn-dynamic {
            background-color: var(--dynamic-theme);
            transition: all 0.3s ease;
        }
        .btn-dynamic:hover { filter: brightness(1.2); transform: translateY(-2px); }

        /* Alerta estilo tu captura */
        .alert-hatil {
            background-color: #dcfce7;
            border-left: 4px solid var(--dynamic-theme);
            color: #15803d;
        }
    </style>

    <x-slot name="header">
        <div id="system-header-bg" class="w-full transition-all duration-500 rounded-b-[2.5rem] shadow-2xl">
            <div class="max-w-7xl mx-auto px-6 py-10">
                <div class="reveal flex flex-col md:flex-row justify-between items-center gap-6">
                    <div>
                        <nav class="flex mb-2 text-white/30 text-[10px] font-black uppercase tracking-[0.4em]">
                            <span>HATIL MANAGEMENT</span> <span class="mx-2">/</span> <span>USUARIOS</span>
                        </nav>
                        <h2 class="font-hatil font-black text-4xl text-white tracking-tighter italic uppercase">
                            Gestión <span class="text-white/40">de Personal</span>
                        </h2>
                    </div>
                    
                    <a href="{{ route('admin.users.create') }}" class="btn-dynamic text-white font-black uppercase text-[10px] px-8 py-4 rounded-2xl tracking-widest italic shadow-xl">
                        + Crear Nuevo Usuario
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div id="main-wrapper" class="py-12 min-h-screen transition-all duration-500 font-hatil">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Mensajes de Sistema --}}
            @if (session('success'))
                <div class="alert-hatil p-5 rounded-2xl mb-8 flex items-center shadow-sm reveal">
                    <span class="text-sm font-bold italic uppercase">{{ session('success') }}</span>
                </div>
            @endif

            {{-- Barra de Búsqueda Profesional --}}
            <div class="mb-10 reveal">
                <form method="GET" action="{{ route('admin.users.index') }}" class="flex gap-3">
                    <div class="relative flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Buscar por nombre o correo electrónico..." 
                               class="w-full bg-white border-none rounded-2xl px-8 py-4 shadow-sm text-sm focus:ring-2 focus:ring-[var(--dynamic-theme)] transition-all">
                        <span class="absolute right-6 top-4 opacity-20 text-xl">🔍</span>
                    </div>
                    <button type="submit" class="btn-dynamic px-8 rounded-2xl text-white font-black text-[10px] uppercase italic">
                        Filtrar
                    </button>
                    @if (request('search'))
                        <a href="{{ route('admin.users.index') }}" class="bg-white px-6 flex items-center rounded-2xl text-slate-400 font-black text-[10px] uppercase hover:bg-slate-100 transition-all">
                            Limpiar
                        </a>
                    @endif
                </form>
            </div>

            {{-- Listado de Usuarios --}}
            <div class="overflow-x-auto reveal">
                <table class="w-full user-table">
                    <thead>
                        <tr class="text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">
                            <th class="px-8 pb-4">ID</th>
                            <th class="px-8 pb-4">Usuario</th>
                            <th class="px-8 pb-4">Rol del Sistema</th>
                            <th class="px-8 pb-4 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr class="user-row">
                            <td class="px-8 py-6 rounded-l-[2.5rem] text-xs font-black text-slate-300">
                                #{{ $user->id }}
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="h-11 w-11 rounded-xl bg-slate-100 flex items-center justify-center font-black text-slate-400 text-sm">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-slate-900 uppercase italic leading-none mb-1">{{ $user->name }}</p>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest
                                    @if($user->rol_type === 'admin') bg-red-50 text-red-600 
                                    @elseif($user->rol_type === 'employee') bg-blue-50 text-blue-600
                                    @else bg-slate-100 text-slate-600 @endif">
                                    {{ $user->rol_type ?? 'cliente' }}
                                </span>
                            </td>
                            <td class="px-8 py-6 rounded-r-[2.5rem] text-right">
                                <div class="flex justify-end items-center gap-3">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="p-3 bg-slate-50 hover:bg-slate-900 hover:text-white rounded-xl transition-all text-sm shadow-sm">
                                        ✏️
                                    </a>
                                    
                                    @if (auth()->user()->id !== $user->id)
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" 
                                              onsubmit="return confirm('¿Eliminar permanentemente a este usuario?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-3 bg-red-50 hover:bg-red-600 hover:text-white rounded-xl transition-all text-sm shadow-sm">
                                                🗑️
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-[9px] font-black text-slate-300 uppercase italic mr-2">Tú</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Paginación HATIL Style --}}
            <div class="mt-10 mb-20">
                {{ $users->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

    <script>
        function applyHatilTheme() {
            const color = localStorage.getItem('hatil_theme_color') || '#065f46';
            const bgColor = localStorage.getItem('hatil_bg_color') || '#ecfdf5';
            
            document.documentElement.style.setProperty('--dynamic-theme', color);
            document.documentElement.style.setProperty('--dynamic-bg', bgColor);

            const header = document.getElementById('system-header-bg');
            const wrapper = document.getElementById('main-wrapper');
            
            if(header) header.style.backgroundColor = color;
            if(wrapper) wrapper.style.backgroundColor = bgColor;
        }

        document.addEventListener('DOMContentLoaded', applyHatilTheme);
    </script>
</x-app-layout>