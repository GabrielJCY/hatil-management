<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'HATIL') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,900&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-900">
        {{-- 1. Contenedor Principal con el GIF de fondo --}}
        <div class="auth-bg-custom" 
             style="background-image: linear-gradient(rgba(15, 23, 42, 0.6), rgba(15, 23, 42, 0.6)), url('{{ asset('images/gift.gif') }}');">
            
            {{-- 2. Capa de contenido (Wrapper) --}}
            <div class="auth-content-wrapper py-12">
                
                {{-- 3. Identidad Visual: Logo HATIL --}}
                <div class="mb-12 text-center">
                    <a href="/" class="flex flex-col items-center group transition-transform duration-500 hover:scale-105">
                        <h1 class="text-6xl font-[900] tracking-tighter text-white drop-shadow-[0_10px_20px_rgba(0,0,0,0.4)]">
                            HATIL<span class="text-slate-400 group-hover:text-white transition-colors duration-300">.</span>
                        </h1>
                        {{-- Línea decorativa minimalista --}}
                        <div class="h-[3px] w-16 bg-gradient-to-r from-transparent via-white to-transparent mt-2 opacity-60"></div>
                        <p class="text-[11px] font-black uppercase tracking-[0.6em] text-white mt-4 drop-shadow-md">
                            Gestión Administrativa
                        </p>
                    </a>
                </div>

                {{-- 4. Tarjeta de Login (Contenedor del formulario) --}}
                {{-- Nota: login-card-custom ahora tiene el blur(12px) y la opacidad 0.85 del CSS --}}
                <div class="w-full sm:max-w-md login-card-custom overflow-hidden">
                    <div class="p-8 sm:p-12">
                        {{ $slot }}
                    </div>
                </div>

                {{-- 5. Footer Corporativo --}}
                <div class="mt-12 text-center">
                    <p class="text-white/50 text-[10px] font-black uppercase tracking-[0.4em] drop-shadow-sm">
                        &copy; {{ date('Y') }} HATIL Furniture 
                        <span class="mx-2 text-white/20">|</span> 
                        Panel de Acceso Seguro
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>