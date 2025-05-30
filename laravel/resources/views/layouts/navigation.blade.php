<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 navbar2">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img id="logoImage" src="img/logo.png" alt="Logo" loading="lazy" class="block h-16 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Home') }}
                    </x-nav-link>
                    <x-nav-link :href="route('blogs')" :active="request()->routeIs('blogs')">
                        {{ __('Blogok') }}
                    </x-nav-link>
                    <x-nav-link :href="route('attractions')" :active="request()->routeIs('attractions')">
                        {{ __('Látványosságok') }}
                    </x-nav-link>
                    @auth
                        <x-nav-link :href="route('tours')" :active="request()->routeIs('tours')">
                            {{ __('Túrák') }}
                        </x-nav-link>
                    @endauth
                    <x-nav-link :href="route('about-us')" :active="request()->routeIs('about-us')">
                        {{ __('Rólunk') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            @auth
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('tours_make')">
                                {{ __('Túrák létrehozása') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('favorites')">
                                {{ __('Kedvencek') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profil') }}
                            </x-dropdown-link>
                            @if(auth()->check() && (auth()->user()->role == 2 || auth()->user()->role == 3))
                            <x-dropdown-link href="{{ url('static-pages/admin/index.php?role=' . Auth::user()->role) }}">
                                {{ __('Admin') }}
                            </x-dropdown-link>

                            @endif

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Kijelentkezés') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
                
            @endauth

            <style>
                .register_menu {
                    display: flex;
                    align-items: center;
                    margin-top:0;
                    height:64px;
                }

                .register_menu a {
                    margin-right: 10px; 
                }
            </style>

            @guest
                @if (Route::has('login'))
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                            {{ __('Log in') }}
                        </x-nav-link>

                        @if (Route::has('register'))
                            <x-nav-link :href="route('register')" :active="request()->routeIs('register')">
                                {{ __('Register') }}
                            </x-nav-link>
                        @endif
                    </div>
                @endif
            @endguest

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
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
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t dark:border-gray-600" style="background-color:#3b5147;">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name ?? '' }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email ?? ''}}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('blogs')">
                    {{ __('Blogok') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('attractions')">
                    {{ __('Látványosságok') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('about-us')">
                    {{ __('Rólunk') }}
                </x-responsive-nav-link>
                @auth
                    <x-responsive-nav-link :href="route('tours')">
                        {{ __('Túrák') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('tours_make')">
                        {{ __('Túrák létrehozása') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('favorites')">
                        {{ __('Kedvencek') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Beállítások') }}
                    </x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Kijelentkezés') }}
                        </x-responsive-nav-link>
                    </form>
                @endauth
                @guest
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Log in') }}
                    </x-responsive-nav-link>
                    @if (Route::has('register'))
                        <x-responsive-nav-link :href="route('register')">
                            {{ __('Register') }}
                        </x-responsive-nav-link>
                    @endif
                @endguest
            </div>
        </div>
    </div>
</nav>
