<nav x-data="{ open: false }" class="bg-gradient-to-r from-gray-800 to-gray-900 border-b border-gray-900 shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-14 w-auto fill-current text-white" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:text-white hover:bg-gray-700 transition duration-150 ease-in-out px-3 py-2 rounded-md">
                        <i class="fas fa-home me-1"></i>{{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link :href="route('sedes.index')" :active="request()->routeIs('sedes.*')" class="text-white hover:text-white hover:bg-gray-700 transition duration-150 ease-in-out px-3 py-2 rounded-md">
                        <i class="fas fa-building me-1"></i>{{ __('Sedes') }}
                    </x-nav-link>

                    <x-nav-link :href="route('bloques.index')" :active="request()->routeIs('bloques.*')" class="text-white hover:text-white hover:bg-gray-700 transition duration-150 ease-in-out px-3 py-2 rounded-md">
                        <i class="fas fa-cubes me-1"></i>{{ __('Bloques') }}
                    </x-nav-link>

                    <x-nav-link :href="route('ubicaciones.index')" :active="request()->routeIs('ubicaciones.*')" class="text-white hover:text-white hover:bg-gray-700 transition duration-150 ease-in-out px-3 py-2 rounded-md">
                        <i class="fas fa-map-marker-alt me-1"></i>{{ __('Ubicaciones') }}
                    </x-nav-link>

                    <x-nav-link :href="route('switches.index')" :active="request()->routeIs('switches.*')" class="text-white hover:text-white hover:bg-gray-700 transition duration-150 ease-in-out px-3 py-2 rounded-md">
                        <i class="fas fa-network-wired me-1"></i>{{ __('Switches') }}
                    </x-nav-link>

                    <x-nav-link :href="route('racks.index')" :active="request()->routeIs('racks.*')" class="text-white hover:text-white hover:bg-gray-700 transition duration-150 ease-in-out px-3 py-2 rounded-md">
                        <i class="fas fa-server me-1"></i>{{ __('Racks') }}
                    </x-nav-link>

                    <x-nav-link :href="route('cargos.index')" :active="request()->routeIs('cargos.*')" class="text-white hover:text-white hover:bg-gray-700 transition duration-150 ease-in-out px-3 py-2 rounded-md">
                        <i class="fas fa-briefcase me-1"></i>{{ __('Cargos') }}
                    </x-nav-link>

                    <x-nav-link :href="route('empleados.index')" :active="request()->routeIs('empleados.*')" class="text-white hover:text-white hover:bg-gray-700 transition duration-150 ease-in-out px-3 py-2 rounded-md">
                        <i class="fas fa-users me-1"></i>{{ __('Empleados') }}
                    </x-nav-link>

                    <x-nav-link :href="route('softphones.index')" :active="request()->routeIs('softphones.*')" class="text-white hover:text-white hover:bg-gray-700 transition duration-150 ease-in-out px-3 py-2 rounded-md">
                        <i class="fas fa-headset me-1"></i>{{ __('Softphones') }}
                    </x-nav-link>

                    <x-nav-link :href="route('extensiones.index')" :active="request()->routeIs('extensiones.*')" class="text-white hover:text-white hover:bg-gray-700 transition duration-150 ease-in-out px-3 py-2 rounded-md">
                        <i class="fas fa-phone me-1"></i>{{ __('Extensiones') }}
                    </x-nav-link>

                    <x-nav-link :href="route('historial.index')" :active="request()->routeIs('historial.*')" class="text-white hover:text-white hover:bg-gray-700 transition duration-150 ease-in-out px-3 py-2 rounded-md">
                        <i class="fas fa-history me-1"></i>{{ __('Historial') }}
                    </x-nav-link>

                    <x-nav-link :href="route('reportes.index')" :active="request()->routeIs('reportes.*')" class="text-white hover:text-white hover:bg-gray-700 transition duration-150 ease-in-out px-3 py-2 rounded-md" style="display: block !important; visibility: visible !important; opacity: 1 !important; font-weight: bold; background-color: rgba(79, 70, 229, 0.2);">
                        <i class="fas fa-chart-bar me-1"></i>{{ __('Reportes') }} 
                    </x-nav-link>
                </div>
            </div>

            <!-- Registro Button - Always visible -->
            <div class="hidden sm:flex sm:items-center mr-4">
                <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none transition ease-in-out duration-150">
                    <i class="fas fa-user-plus me-2"></i>Registrar Usuario
                </a>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-gray-800 hover:text-white hover:bg-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:text-white hover:bg-gray-700 transition duration-150 ease-in-out px-3 py-2 rounded-md">
                <i class="fas fa-home me-1"></i>{{ __('Dashboard') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('sedes.index')" :active="request()->routeIs('sedes.*')" class="text-white hover:text-white hover:bg-gray-700 transition duration-150 ease-in-out px-3 py-2 rounded-md">
                <i class="fas fa-building me-1"></i>{{ __('Sedes') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('bloques.index')" :active="request()->routeIs('bloques.*')" class="text-white hover:text-white hover:bg-gray-700 transition duration-150 ease-in-out px-3 py-2 rounded-md">
                <i class="fas fa-cubes me-1"></i>{{ __('Bloques') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('ubicaciones.index')" :active="request()->routeIs('ubicaciones.*')" class="text-white hover:text-white hover:bg-gray-700 transition duration-150 ease-in-out px-3 py-2 rounded-md">
                <i class="fas fa-map-marker-alt me-1"></i>{{ __('Ubicaciones') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('switches.index')" :active="request()->routeIs('switches.*')" class="text-white hover:text-white hover:bg-gray-700 transition duration-150 ease-in-out px-3 py-2 rounded-md">
                <i class="fas fa-network-wired me-1"></i>{{ __('Switches') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('racks.index')" :active="request()->routeIs('racks.*')" class="text-white hover:text-white hover:bg-gray-700 transition duration-150 ease-in-out px-3 py-2 rounded-md">
                <i class="fas fa-server me-1"></i>{{ __('Racks') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('cargos.index')" :active="request()->routeIs('cargos.*')" class="text-white hover:text-white hover:bg-gray-700 transition duration-150 ease-in-out px-3 py-2 rounded-md">
                <i class="fas fa-briefcase me-1"></i>{{ __('Cargos') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('empleados.index')" :active="request()->routeIs('empleados.*')" class="text-white hover:text-white hover:bg-gray-700 transition duration-150 ease-in-out px-3 py-2 rounded-md">
                <i class="fas fa-users me-1"></i>{{ __('Empleados') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('softphones.index')" :active="request()->routeIs('softphones.*')" class="text-white hover:text-white hover:bg-gray-700 transition duration-150 ease-in-out px-3 py-2 rounded-md">
                <i class="fas fa-headset me-1"></i>{{ __('Softphones') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('extensiones.index')" :active="request()->routeIs('extensiones.*')" class="text-white hover:text-white hover:bg-gray-700 transition duration-150 ease-in-out px-3 py-2 rounded-md">
                <i class="fas fa-phone me-1"></i>{{ __('Extensiones') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('historial.index')" :active="request()->routeIs('historial.*')" class="text-white hover:text-white hover:bg-gray-700 transition duration-150 ease-in-out px-3 py-2 rounded-md">
                <i class="fas fa-history me-1"></i>{{ __('Historial') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('reportes.index')" :active="request()->routeIs('reportes.*')" class="text-white hover:text-white hover:bg-gray-700 transition duration-150 ease-in-out px-3 py-2 rounded-md" style="display: block !important; visibility: visible !important; opacity: 1 !important; font-weight: bold; background-color: rgba(79, 70, 229, 0.2);">
                <i class="fas fa-chart-bar me-1"></i>{{ __('Reportes') }} 
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')" class="text-white hover:text-white hover:bg-indigo-700 transition duration-150 ease-in-out px-3 py-2 rounded-md bg-indigo-600">
                <i class="fas fa-user-plus me-1"></i>{{ __('Registrar Usuario') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-white">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Cerrar Sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
