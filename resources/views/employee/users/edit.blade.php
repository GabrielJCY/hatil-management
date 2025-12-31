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
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .hatil-input {
            width: 100%;
            background-color: #f8fafc;
            border: 2px solid #f1f5f9;
            border-radius: 1.25rem;
            padding: 0.85rem 1.25rem;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .hatil-input:focus {
            background-color: white;
            border-color: var(--dynamic-theme);
            outline: none;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        }

        .btn-dynamic {
            background-color: var(--dynamic-theme);
            transition: all 0.3s ease;
        }
        .btn-dynamic:hover { 
            filter: brightness(1.2); 
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(0,0,0,0.2);
        }

        label {
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: #94a3b8;
            margin-left: 0.75rem;
            margin-bottom: 0.5rem;
            display: block;
        }

        .error-badge {
            background-color: #fee2e2;
            border-left: 4px solid #ef4444;
            color: #991b1b;
        }

        .info-card {
            background-color: #f0f9ff;
            border-left: 4px solid #0ea5e9;
            color: #0c4a6e;
        }
    </style>

    <x-slot name="header">
        <div id="system-header-bg" class="w-full transition-all duration-500 rounded-b-[3.5rem] shadow-2xl">
            <div class="max-w-7xl mx-auto px-6 py-12">
                <div class="reveal flex flex-col md:flex-row justify-between items-center gap-4">
                    <div>
                        <nav class="flex mb-3 text-white/30 text-[9px] font-black uppercase tracking-[0.5em]">
                            <span>SISTEMA</span> <span class="mx-2">/</span> <span>USUARIOS</span> <span class="mx-2">/</span> <span>EDICIÓN</span>
                        </nav>
                        <h2 class="font-hatil font-black text-4xl text-white tracking-tighter italic uppercase leading-none">
                            Editar <span class="text-white/40">{{ $user->name }}</span>
                        </h2>
                    </div>
                    <div class="bg-white/10 px-6 py-3 rounded-2xl backdrop-blur-sm border border-white/10">
                        <p class="text-[9px] font-black text-white/40 uppercase tracking-widest leading-none mb-1">ID Registro</p>
                        <p class="text-xl font-black text-white italic">#{{ $user->id }}</p>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div id="main-wrapper" class="py-12 min-h-screen transition-all duration-500 font-hatil">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Manejo de Errores Profesional --}}
            @if ($errors->any())
                <div class="error-badge p-6 rounded-[2rem] mb-8 reveal shadow-sm">
                    <p class="text-[10px] font-black uppercase tracking-widest mb-2 italic underline">Errores de validación:</p>
                    <ul class="list-disc list-inside text-xs font-bold space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-[3.5rem] p-10 md:p-16 shadow-2xl reveal border border-slate-50">
                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h3 class="text-[11px] font-black text-slate-900 uppercase tracking-[0.3em] mb-8 italic border-b border-slate-100 pb-4">
                        Información General
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 mb-12">
                        {{-- Nombre --}}
                        <div class="space-y-1">
                            <label for="name">Nombre de Usuario</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required autofocus
                                   class="hatil-input">
                        </div>

                        {{-- Email --}}
                        <div class="space-y-1">
                            <label for="email">Email Corporativo</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                                   class="hatil-input">
                        </div>

                        {{-- Rol Type --}}
                        <div class="space-y-1">
                            <label for="rol_type">Nivel de Acceso</label>
                            <div class="relative">
                                <select name="rol_type" id="rol_type" required class="hatil-input appearance-none cursor-pointer">
                                    <option value="" disabled>Seleccione un Rol</option>
                                    <option value="client" {{ old('rol_type', $user->rol_type) == 'client' ? 'selected' : '' }}>Usuario / Cliente</option>
                                    <option value="employee" {{ old('rol_type', $user->rol_type) == 'employee' ? 'selected' : '' }}>Empleado / Vendedor</option>
                                    <option value="admin" {{ old('rol_type', $user->rol_type) == 'admin' ? 'selected' : '' }}>Administrador</option>
                                </select>
                                <div class="absolute right-5 top-4 pointer-events-none opacity-30 text-xs">▼</div>
                            </div>
                        </div>

                        {{-- Carnet --}}
                        <div class="space-y-1">
                            <label for="carnet">Documento Identidad (CI)</label>
                            <input type="text" name="carnet" id="carnet" value="{{ old('carnet', $user->carnet) }}"
                                   class="hatil-input">
                        </div>
                    </div>

                    {{-- Sección de Seguridad --}}
                    <div class="info-card p-6 rounded-[2rem] mb-8 flex flex-col md:flex-row gap-4 items-center">
                        <div class="text-2xl">🔐</div>
                        <div>
                            <h4 class="text-xs font-black uppercase tracking-tighter">Seguridad Opcional</h4>
                            <p class="text-[10px] font-medium opacity-70 uppercase tracking-tight">Solo completa estos campos si deseas actualizar la contraseña actual.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        {{-- Password --}}
                        <div class="space-y-1">
                            <label for="password">Nueva Contraseña</label>
                            <input type="password" name="password" id="password" autocomplete="new-password"
                                   class="hatil-input" placeholder="••••••••">
                        </div>

                        {{-- Confirm Password --}}
                        <div class="space-y-1">
                            <label for="password_confirmation">Confirmar Nueva Clave</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password"
                                   class="hatil-input" placeholder="••••••••">
                        </div>
                    </div>

                    {{-- Footer de Formulario --}}
                    <div class="mt-16 pt-8 border-t border-slate-100 flex items-center justify-between gap-6">
                        <a href="{{ route('admin.users.index') }}" 
                           class="text-[10px] font-black uppercase text-slate-400 hover:text-slate-900 transition-colors tracking-widest italic">
                            ← Cancelar y Volver
                        </a>
                        
                        <button type="submit" class="btn-dynamic text-white font-black uppercase text-[11px] px-12 py-5 rounded-[1.5rem] tracking-[0.2em] italic shadow-xl">
                            Actualizar Usuario
                        </button>
                    </div>
                </form>
            </div>

            <p class="text-center mt-12 text-[9px] font-black text-slate-300 uppercase tracking-[0.4em]">
                Hatil Architecture & Furniture — Administrative Edit Mode
            </p>
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