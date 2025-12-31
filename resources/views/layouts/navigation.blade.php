<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-md">

    {{-- 1. Barra de Navegación Superior --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                
                {{-- Logo --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                {{-- Enlaces de Navegación (Escritorio) --}}
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    {{-- Catálogo siempre visible --}}
                    <x-nav-link :href="route('client.catalogo.index')" :active="request()->routeIs('client.catalogo.index')">
                        {{ __('Catálogo') }}
                    </x-nav-link>

                    @auth
                        {{-- 📊 SOLO PARA ADMIN: Se activa si rol_type es 'admin' --}}
                        @if(Auth::user()->rol_type === 'admin')
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard') || request()->routeIs('employee.dashboard')">
                                <span class="font-bold text-blue-600">{{ __('📊 Panel de Control') }}</span>
                            </x-nav-link>
                        @endif

                        {{-- 🛒 SOLO PARA CLIENTES: Se activa si rol_type es 'cliente' --}}
                        @if(Auth::user()->rol_type === 'cliente')
                            <x-nav-link :href="route('client.carrito.index')" :active="request()->routeIs('client.carrito.index')">
                                {{ __('Carrito') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            {{-- Menú de Usuario / Login --}}
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div class="flex items-center">
                                    {{-- Badge de Rol --}}
                                    @if(Auth::user()->rol_type === 'admin')
                                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded italic">Admin</span>
                                    @endif
                                    {{ Auth::user()->name }}
                                </div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @if(Auth::user()->rol_type === 'admin')
                                <x-dropdown-link :href="route('dashboard')">
                                    {{ __('Panel de Control') }}
                                </x-dropdown-link>
                                <hr class="border-gray-100">
                            @endif

                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Perfil') }}
                            </x-dropdown-link>

                            {{-- LOGOUT FORM: Crucial para evitar Error 419 --}}
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Cerrar Sesión') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 underline mx-2">Iniciar Sesión</a>
                    <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Registrarse</a>
                @endauth
            </div>

            {{-- Botón Menú Móvil --}}
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- 2. Menú Móvil (Responsive) --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('client.catalogo.index')" :active="request()->routeIs('client.catalogo.index')">
                {{ __('Catálogo') }}
            </x-responsive-nav-link>

            @auth
                @if(Auth::user()->rol_type === 'admin')
                    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-blue-600 font-bold">
                        {{ __('📊 Panel de Control') }}
                    </x-responsive-nav-link>
                @elseif(Auth::user()->rol_type === 'cliente')
                    <x-responsive-nav-link :href="route('client.carrito.index')" :active="request()->routeIs('client.carrito.index')">
                        {{ __('Carrito') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        @auth
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Perfil') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Cerrar Sesión') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>