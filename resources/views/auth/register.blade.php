<x-guest-layout>
    {{-- Título interno --}}
    <div class="mb-8">
        <h2 class="text-3xl font-black text-slate-900 tracking-tight">Crear Cuenta</h2>
        <p class="text-sm text-slate-700 font-bold mt-2 leading-relaxed">
            Únete a HATIL. Registra tus datos para comenzar.
        </p>
    </div>

    {{-- Bloque para ver errores de validación (IMPORTANTE PARA DEBUG) --}}
    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-bold text-red-800 uppercase tracking-wider">Revisa los siguientes campos:</h3>
                    <ul class="mt-1 list-disc list-inside text-xs text-red-700 font-medium">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Nombre --}}
        <div class="relative">
            <x-input-label for="name" :value="__('Nombre Completo')" class="label-premium" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <x-text-input id="name" class="input-with-icon" type="text" name="name" :value="old('name')" required autofocus placeholder="Ej. Juan Pérez" />
            </div>
        </div>

        {{-- CARNET (CAMPO CRÍTICO PARA EL GUARDADO) --}}
        <div class="mt-5 relative">
            <x-input-label for="carnet" :value="__('Carnet de Identidad')" class="label-premium" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.333 0 4 1 4 3" />
                    </svg>
                </div>
                <x-text-input id="carnet" class="input-with-icon" type="text" name="carnet" :value="old('carnet')" required placeholder="Número de Carnet" />
            </div>
        </div>

        {{-- Email --}}
        <div class="mt-5 relative">
            <x-input-label for="email" :value="__('Correo Electrónico')" class="label-premium" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <x-text-input id="email" class="input-with-icon" type="email" name="email" :value="old('email')" required placeholder="correo@ejemplo.com" />
            </div>
        </div>

        {{-- Password --}}
        <div class="mt-5 relative">
            <x-input-label for="password" :value="__('Contraseña')" class="label-premium" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <x-text-input id="password" class="input-with-icon" type="password" name="password" required placeholder="••••••••" />
            </div>
        </div>

        {{-- Confirm Password --}}
        <div class="mt-5 relative">
            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" class="label-premium" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04M12 21.355r-.015.015V21.355z" />
                    </svg>
                </div>
                <x-text-input id="password_confirmation" class="input-with-icon" type="password" name="password_confirmation" required placeholder="••••••••" />
            </div>
        </div>

        {{-- Acciones --}}
        <div class="mt-10 space-y-4">
            <button type="submit" class="btn-premium">
                {{ __('Registrar Cuenta') }}
            </button>

            <div class="text-center">
                <a class="text-xs text-slate-900 hover:text-black font-black uppercase tracking-widest transition-all" href="{{ route('login') }}">
                    {{ __('¿Ya tienes cuenta? Inicia Sesión') }}
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>