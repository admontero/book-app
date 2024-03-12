<aside
    x-data
    x-cloak
    x-on:resize.window="window.innerWidth < 1280 ? $store.sidebar.on = false : $store.sidebar.on = true"
    :class="$store.sidebar.on ? 'w-64' : 'w-[5.5rem]'"
    class="sticky top-0 hidden sm:flex flex-col min-h-screen px-5 py-8 overflow-y-visible bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700
        transition-[width] ease-in-out duration-150"
>
    {{-- <button
        x-data
        x-tooltip.placement.right.delay.50="{ content: () => $store.sidebar.on ? 'Contraer' : 'Expandir' }"
        class="hidden lg:flex justify-center items-center absolute p-2 top-3 -right-5 bg-gray-100 rounded-md overflow-x-hidden focus:outline-none dark:bg-gray-700"
        @click="$store.sidebar.toggle()"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-square-rounded-chevron-right w-5 h-5 text-gray-600 hover:text-gray-900 dark:text-white dark:hover:text-gray-300" :class="$store.sidebar.on ? 'rotate-180' : 'rotate-0'" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11 9l3 3l-3 3" /><path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z" /></svg>
    </button> --}}

    <a href="{{ route('dashboard') }}" wire:navigate>
        <img x-show="! $store.darkMode.on" class="mx-auto object-cover max-h-24" src="{{ asset('dist/images/logo.png') }}" alt="application logo">
        <img x-show="$store.darkMode.on" class="mx-auto object-cover max-h-24" src="{{ asset('dist/images/logo-dark.png') }}" alt="application logo">
    </a>

    <div class="flex flex-col justify-between flex-1 mt-6">
        <nav class="space-y-6">
            <div class="space-y-3">
                <label class="px-3 text-xs text-gray-500 uppercase dark:text-gray-400" x-show="$store.sidebar.on">sistema</label>

                <a
                    class="flex items-center px-3 py-2 text-gray-600 transform rounded-lg dark:text-gray-200
                    hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700
                    {{ request()->routeIs('dashboard') ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                    x-data="{ tooltip: ! $store.sidebar.on ? 'Dashboard' : false }"
                    x-init="$watch('$store.sidebar.on', value => tooltip = ! value ? 'Dashboard' : false )"
                    x-tooltip.placement.right.delay.50="tooltip"
                    href="/"
                    wire:navigate
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-layout-dashboard w-5 h-5" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 4h6v8h-6z" /><path d="M4 16h6v4h-6z" /><path d="M14 12h6v8h-6z" /><path d="M14 4h6v4h-6z" /></svg>

                    <span class="mx-2 text-sm font-medium" x-show="$store.sidebar.on">Dashboard</span>
                </a>

                <a
                    class="flex items-center px-3 py-2 text-gray-600 transform rounded-lg dark:text-gray-200 hover:bg-gray-100
                        dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700"
                    x-data="{ tooltip: ! $store.sidebar.on ? 'Préstamos' : false }"
                    x-init="$watch('$store.sidebar.on', value => tooltip = ! value ? 'Préstamos' : false )"
                    x-tooltip.placement.right.delay.50="tooltip"
                    href="#"
                    wire:navigate
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-receipt w-5 h-5" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16l-3 -2l-2 2l-2 -2l-2 2l-2 -2l-3 2m4 -14h6m-6 4h6m-2 4h2" /></svg>

                    <span class="mx-2 text-sm font-medium" x-show="$store.sidebar.on">Préstamos</span>
                </a>

                <a
                    class="flex items-center px-3 py-2 text-gray-600 transform rounded-lg dark:text-gray-200 hover:bg-gray-100
                        dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700
                        {{ request()->routeIs('admin.users.*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                    x-data="{ tooltip: ! $store.sidebar.on ? 'Usuarios' : false }"
                    x-init="$watch('$store.sidebar.on', value => tooltip = ! value ? 'Usuarios' : false )"
                    x-tooltip.placement.right.delay.50="tooltip"
                    href="{{ route('admin.users.index') }}"
                    wire:navigate
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users-group w-5 h-5" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1" /><path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M17 10h2a2 2 0 0 1 2 2v1" /><path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M3 13v-1a2 2 0 0 1 2 -2h2" /></svg>

                    <span class="mx-2 text-sm font-medium" x-show="$store.sidebar.on">Usuarios</span>
                </a>

                <a
                    class="flex items-center px-3 py-2 text-gray-600 transform rounded-lg dark:text-gray-200 hover:bg-gray-100
                        dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700"
                    x-data="{ tooltip: ! $store.sidebar.on ? 'Copias' : false }"
                    x-init="$watch('$store.sidebar.on', value => tooltip = ! value ? 'Copias' : false )"
                    x-tooltip.placement.right.delay.50="tooltip"
                    href="#"
                    wire:navigate
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-books w-5 h-5" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 4m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" /><path d="M9 4m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" /><path d="M5 8h4" /><path d="M9 16h4" /><path d="M13.803 4.56l2.184 -.53c.562 -.135 1.133 .19 1.282 .732l3.695 13.418a1.02 1.02 0 0 1 -.634 1.219l-.133 .041l-2.184 .53c-.562 .135 -1.133 -.19 -1.282 -.732l-3.695 -13.418a1.02 1.02 0 0 1 .634 -1.219l.133 -.041z" /><path d="M14 9l4 -1" /><path d="M16 16l3.923 -.98" /></svg>

                    <span class="mx-2 text-sm font-medium" x-show="$store.sidebar.on">Copias</span>
                </a>
            </div>

            <div class="space-y-3">
                <label class="px-3 text-xs text-gray-500 uppercase dark:text-gray-400" x-show="$store.sidebar.on">configuración</label>

                <a
                    class="flex items-center px-3 py-2 text-gray-600 transform rounded-lg dark:text-gray-200 hover:bg-gray-100
                        dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700
                        {{ request()->routeIs('admin.roles.*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                    x-data="{ tooltip: ! $store.sidebar.on ? 'Roles' : false }"
                    x-init="$watch('$store.sidebar.on', value => tooltip = ! value ? 'Roles' : false )"
                    x-tooltip.placement.right.delay.50="tooltip"
                    href="{{ route('admin.roles.index') }}"
                    wire:navigate
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-shield w-5 h-5" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 21v-2a4 4 0 0 1 4 -4h2" /><path d="M22 16c0 4 -2.5 6 -3.5 6s-3.5 -2 -3.5 -6c1 0 2.5 -.5 3.5 -1.5c1 1 2.5 1.5 3.5 1.5z" /><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /></svg>

                    <span class="mx-2 text-sm font-medium" x-show="$store.sidebar.on">Roles</span>
                </a>

                <a
                    class="flex items-center px-3 py-2 text-gray-600 transform rounded-lg dark:text-gray-200 hover:bg-gray-100
                        dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700
                        {{ request()->routeIs('admin.permissions.*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                    x-data="{ tooltip: ! $store.sidebar.on ? 'Permisos' : false }"
                    x-init="$watch('$store.sidebar.on', value => tooltip = ! value ? 'Permisos' : false )"
                    x-tooltip.placement.right.delay.50="tooltip"
                    href="{{ route('admin.permissions.index') }}"
                    wire:navigate
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-key w-5 h-5" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z" /><path d="M15 9h.01" /></svg>

                    <span class="mx-2 text-sm font-medium" x-show="$store.sidebar.on">Permisos</span>
                </a>
            </div>

            <div class="space-y-3">
                <label class="px-3 text-xs text-gray-500 uppercase dark:text-gray-400" x-show="$store.sidebar.on">datos</label>

                <a
                    class="flex items-center px-3 py-2 text-gray-600 transform rounded-lg dark:text-gray-200 hover:bg-gray-100
                        dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700"
                    x-data="{ tooltip: ! $store.sidebar.on ? 'Libros' : false }"
                    x-init="$watch('$store.sidebar.on', value => tooltip = ! value ? 'Libros' : false )"
                    x-tooltip.placement.right.delay.50="tooltip"
                    href="#"
                    wire:navigate
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-book-2 w-5 h-5" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19 4v16h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12z" /><path d="M19 16h-12a2 2 0 0 0 -2 2" /><path d="M9 8h6" /></svg>

                    <span class="mx-2 text-sm font-medium" x-show="$store.sidebar.on">Libros</span>
                </a>

                <a
                    class="flex items-center px-3 py-2 text-gray-600 transform rounded-lg dark:text-gray-200 hover:bg-gray-100
                        dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700
                        {{ request()->routeIs('admin.authors.*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                    x-data="{ tooltip: ! $store.sidebar.on ? 'Autores' : false }"
                    x-init="$watch('$store.sidebar.on', value => tooltip = ! value ? 'Autores' : false )"
                    x-tooltip.placement.right.delay.50="tooltip"
                    href="{{ route('admin.authors.index') }}"
                    wire:navigate
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-writing w-5 h-5" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 17v-12c0 -1.121 -.879 -2 -2 -2s-2 .879 -2 2v12l2 2l2 -2z" /><path d="M16 7h4" /><path d="M18 19h-13a2 2 0 1 1 0 -4h4a2 2 0 1 0 0 -4h-3" /></svg>

                    <span class="mx-2 text-sm font-medium" x-show="$store.sidebar.on">Autores</span>
                </a>

                <a
                    class="flex items-center px-3 py-2 text-gray-600 transform rounded-lg dark:text-gray-200 hover:bg-gray-100
                        dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700
                        {{ request()->routeIs('admin.genres.*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                    x-data="{ tooltip: ! $store.sidebar.on ? 'Géneros' : false }"
                    x-init="$watch('$store.sidebar.on', value => tooltip = ! value ? 'Géneros' : false )"
                    x-tooltip.placement.right.delay.50="tooltip"
                    href="{{ route('admin.genres.index') }}"
                    wire:navigate
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-category w-5 h-5" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 4h6v6h-6z" /><path d="M14 4h6v6h-6z" /><path d="M4 14h6v6h-6z" /><path d="M17 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /></svg>

                    <span class="mx-2 text-sm font-medium" x-show="$store.sidebar.on">Géneros</span>
                </a>
            </div>
        </nav>
    </div>
</aside>
