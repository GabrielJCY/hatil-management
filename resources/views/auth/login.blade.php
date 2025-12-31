<x-guest-layout>
    {{-- Título interno --}}
    <div class="mb-8">
        <h2 class="text-3xl font-black text-slate-900 tracking-tight">Iniciar Sesión</h2>
        <p class="text-sm text-slate-700 font-bold mt-2 leading-relaxed">
            Introduce tus credenciales para acceder al panel.
        </p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Campo: Email --}}
        <div class="relative">
            <x-input-label for="email" :value="__('Correo Electrónico')" class="label-premium" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <x-text-input id="email" class="input-with-icon" type="email" name="email" :value="old('email')" required autofocus placeholder="ejemplo@hatil.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Campo: Password --}}
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
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Recordarme y Olvido --}}
        <div class="flex items-center justify-between mt-6">
            <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-slate-900 focus:ring-slate-900 w-4 h-4" name="remember">
                <span class="ms-2 text-xs text-slate-700 font-bold uppercase tracking-wider">{{ __('Recordarme') }}</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-xs text-slate-900 hover:text-black font-black uppercase tracking-tighter" href="{{ route('password.request') }}">
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            @endif
        </div>

        {{-- Botón de Entrar --}}
        <div class="mt-8">
            <button type="submit" class="btn-premium">
                {{ __('Entrar al Sistema') }}
            </button>
        </div>

        {{-- SECCIÓN NUEVA: Crear Cuenta --}}
        <div class="mt-8 pt-6 border-t border-slate-200 text-center">
            <p class="text-xs text-slate-500 font-bold uppercase tracking-widest mb-4">
                ¿No tienes una cuenta aún?
            </p>
            <a href="{{ route('register') }}" class="inline-flex items-center justify-center w-full py-3 border-2 border-slate-900 text-slate-900 font-black uppercase tracking-widest text-[10px] rounded-xl hover:bg-slate-900 hover:text-white transition-all duration-300 active:scale-95">
                {{ __('Crear Nueva Cuenta') }}
            </a>
        </div>
    </form>
</x-guest-layout>