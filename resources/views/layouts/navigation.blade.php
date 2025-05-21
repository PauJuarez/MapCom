<nav x-data="{ open: false }" class="bg-primary-variant-2 bg-white ">
    <!-- Primary Navigation Menu -->
    <div class="mx-0 px-0 sm:mx-auto sm:px-6 lg:px-8 xl:px-4 max-w-7xl">
        <div class="flex justify-between items-center h-16 pt-16 pb-14 pl-0 md:pl-8">
            <!-- Logo y Hamburguesa -->
            <div class="flex items-center flex-col sm:flex-row">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('Home') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>
        
                <!-- Hamburger -->
                <div class="sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        
            <!-- Dropdown del usuario alineado a la derecha -->
            <div class="hidden sm:flex sm:items-center mr-5 mb-5">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">

                            <div>{{ Auth::user()->name }}</div>
        
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
        
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Perfil') }}
                        </x-dropdown-link>
        
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                         this.closest('form').submit();">
                                {{ __('Tanca la sessió') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
        
        
        <!-- Navigation Links (Vertical) -->
        <div class="hidden sm:flex flex-col space-y-4 sm:ms-10 ">
            <x-nav-link :href="route('Home')" :active="request()->routeIs('Home')">
                <span class="text-lg">{{ __('Inici') }}</span>
            </x-nav-link>
            <x-nav-link :href="route('botigues.index')" :active="request()->routeIs('botigues.index')">
                <span class="text-lg">{{ __('Botigues') }}</span>
            </x-nav-link>
            <x-nav-link :href="route('botigues.mapa')" :active="request()->routeIs('botigues.mapa')">
                <span class="text-lg">{{ __('Mapa') }}
            </x-nav-link>
            @if(Gate::allows('access-admin') || Gate::allows('access-editor'))
                <x-nav-link :href="route('botigues.crearb')" :active="request()->routeIs('botigues.crearb')">
                    <span class="text-lg">{{ __('Crear Botigues') }}</span>
                </x-nav-link>
            @endif
            @if(Gate::allows('access-admin'))

                <x-nav-link :href="route('botigues.users')" :active="request()->routeIs('botigues.users')">
                    <span class="text-lg">{{ __('Rols d\'Usuaris') }}</span>
                </x-nav-link>
            @endif
        </div>
    </div>
    

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="sm:hidden transition-all duration-300 ease-in-out"
        :class="{'w-14': !open, 'w-64': open, 'max-w-full': open}">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('Home')" :active="request()->routeIs('Home')">
                {{ __('Inici') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('botigues.index')" :active="request()->routeIs('botigues.index')">
                {{ __('Botigues') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('botigues.mapa')" :active="request()->routeIs('botigues.mapa')">
                {{ __('Mapa') }}
            </x-responsive-nav-link>
            @if(Gate::allows('access-admin') || Gate::allows('access-editor'))
                <x-responsive-nav-link :href="route('botigues.crearb')" :active="request()->routeIs('botigues.crearb')">
                    {{ __('Crear Botigues') }}
                </x-responsive-nav-link>
            @endif
            @if(Gate::allows('access-admin'))
                <x-responsive-nav-link :href="route('botigues.users')" :active="request()->routeIs('botigues.users')">
                    {{ __('Rols d\'Usuaris') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- User Info -->
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
                        {{ __('Tanca sessió') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
