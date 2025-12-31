<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-slate-900 leading-tight uppercase tracking-tighter">
            {{ __('Panel de Control') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- MENSAJE DE BIENVENIDA HATIL --}}
            @if (session('success'))
                <div id="welcome-alert" class="mb-8 group">
                    <div class="bg-white border-l-[10px] border-slate-900 shadow-[0_20px_50px_rgba(0,0,0,0.1)] rounded-r-2xl p-8 relative overflow-hidden transition-all duration-500 hover:scale-[1.01]">
                        
                        {{-- Icono de fondo decorativo --}}
                        <div class="absolute right-[-20px] top-[-20px] opacity-[0.03] group-hover:opacity-[0.07] transition-opacity">
                            <svg class="h-64 w-64 text-slate-900" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                            </svg>
                        </div>

                        <div class="flex items-center relative z-10">
                            <div class="flex-shrink-0 bg-slate-900 p-4 rounded-2xl shadow-lg animate-pulse">
                                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div class="ml-6">
                                <h3 class="text-xl font-black text-slate-900 uppercase tracking-tighter">
                                    {{ session('success') }}
                                </h3>
                                <p class="text-slate-500 font-bold mt-1">
                                    Tu cuenta ha sido activada correctamente. Ya puedes gestionar tus pedidos.
                                </p>
                            </div>
                            
                            <button onclick="document.getElementById('welcome-alert').style.display='none'" class="ml-auto bg-slate-100 p-2 rounded-full text-slate-400 hover:text-slate-900 hover:bg-slate-200 transition-all">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Contenido del Dashboard --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-slate-100">
                <div class="p-10 text-slate-700">
                    <p class="font-bold text-lg">Sesión iniciada como: <span class="text-slate-900 font-black underline">{{ Auth::user()->name }}</span></p>
                    <p class="text-sm mt-2">Carnet registrado: {{ Auth::user()->carnet }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>