<div class="sticky top-0 z-10">
    <nav class="bg-white border-gray-200 dark:bg-gray-800">
        <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl p-4">
            <a href="{{ route('front.dashboard') }}" wire:navigate>
                <img x-show="! $store.darkMode.on" class="mx-auto object-cover max-h-11" src="{{ asset('dist/images/logo.png') }}" alt="application logo">
                <img x-show="$store.darkMode.on" class="mx-auto object-cover max-h-11" src="{{ asset('dist/images/logo-dark.png') }}" alt="application logo">
            </a>

            <div class="flex items-center">
                @auth
                    <!-- Settings Dropdown -->
                    <div class="ms-3 relative">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    </button>
                                @else
                                    <span class="inline-flex rounded-md">
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700">
                                            {{ Auth::user()->name }}

                                            <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>
                                    </span>
                                @endif
                            </x-slot>

                            <x-slot name="content">
                                <!-- Account Management -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Manage Account') }}
                                </div>

                                {{-- <x-dropdown-link href="{{ route('profile.show') }}" wire:navigate>
                                    {{ __('Profile') }}
                                </x-dropdown-link> --}}

                                <div class="border-t border-gray-200 dark:border-gray-600"></div>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf

                                    <x-dropdown-link href="{{ route('logout') }}"
                                            @click.prevent="$root.submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    <div>
                        <a
                            class="ms-3 text-gray-700 transition-colors duration-300 transform dark:text-gray-200 hover:text-blue-500 dark:hover:text-blue-400"
                            href="{{ route('login') }}"
                            wire:navigate
                        >Login</a>

                        <a
                            class="ms-3 text-gray-700 transition-colors duration-300 transform dark:text-gray-200 hover:text-blue-500 dark:hover:text-blue-400"
                            href="{{ route('register') }}"
                            wire:navigate
                        >Registro</a>
                    </div>
                @endauth

                <!-- Toggle Theme -->
                <div class="mx-6 relative">
                    <div
                        x-data
                        x-cloak
                        x-init="$store.darkMode.switch()"
                        class="flex items-center justify-center space-x-2"
                    >
                        <button
                            x-ref="switchButton"
                            type="button"
                            @click="$store.darkMode.toggle()"
                            class="text-gray-600 hover:text-gray-900 dark:text-white dark:hover:text-gray-300"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-sun w-5 h-5" x-show="$store.darkMode.on" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" /></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-moon w-5 h-5" x-show="! $store.darkMode.on" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" /></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    @auth
        <nav class="bg-gray-50 dark:bg-gray-700">
            <div class="max-w-screen-xl px-4 py-3 mx-auto">
                <div class="flex items-center">
                    <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm">
                        <li>
                            <a
                                class="text-gray-900 dark:text-white hover:underline"
                                aria-current="page"
                                href="{{ route('front.dashboard') }}"
                                wire:navigate
                            >
                                Inicio
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-900 dark:text-white hover:underline">Mis préstamos</a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-900 dark:text-white hover:underline">Mis sanciones</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    @endauth
</div>
