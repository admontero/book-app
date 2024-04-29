<aside
    class="fixed top-0 left-0 hidden sm:flex flex-col z-40 h-screen transition-[width] ease-in-out duration-150"
    :class="$store.sidebar.on ? 'w-64' : 'w-[5.5rem]'"
    x-on:resize.window="window.innerWidth < 1280 ? $store.sidebar.on = false : $store.sidebar.on = true"
>
    <div class="h-full overflow-y-auto no-scrollbar bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700 px-5 py-8">
        <a href="{{ route('back.dashboard') }}" wire:navigate>
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
                        {{ request()->routeIs('back.dashboard') ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                        x-data="{ tooltip: ! $store.sidebar.on ? 'Dashboard' : false }"
                        x-init="$watch('$store.sidebar.on', value => tooltip = ! value ? 'Dashboard' : false )"
                        x-tooltip.placement.right.delay.50="tooltip"
                        href="{{ route('back.dashboard') }}"
                        wire:navigate
                    >
                        <x-icons.dashboard class="w-5 h-5" />

                        <span class="mx-2 text-sm font-medium" x-show="$store.sidebar.on">Dashboard</span>
                    </a>

                    @can('viewAny', App\Models\Loan::class)
                        <a
                            class="flex items-center px-3 py-2 text-gray-600 transform rounded-lg dark:text-gray-200 hover:bg-gray-100
                                dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700
                                {{ request()->routeIs('back.loans.*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                            x-data="{ tooltip: ! $store.sidebar.on ? 'Préstamos' : false }"
                            x-init="$watch('$store.sidebar.on', value => tooltip = ! value ? 'Préstamos' : false )"
                            x-tooltip.placement.right.delay.50="tooltip"
                            href="{{ route('back.loans.index') }}"
                            wire:navigate
                        >
                            <x-icons.loan class="w-5 h-5" />

                            <span class="mx-2 text-sm font-medium" x-show="$store.sidebar.on">Préstamos</span>
                        </a>
                    @endcan

                    @can('viewAny', App\Models\Fine::class)
                        <a
                            class="flex items-center px-3 py-2 text-gray-600 transform rounded-lg dark:text-gray-200 hover:bg-gray-100
                                dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700
                                {{ request()->routeIs('back.fines.*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                            x-data="{ tooltip: ! $store.sidebar.on ? 'Multas' : false }"
                            x-init="$watch('$store.sidebar.on', value => tooltip = ! value ? 'Multas' : false )"
                            x-tooltip.placement.right.delay.50="tooltip"
                            href="{{ route('back.fines.index') }}"
                            wire:navigate
                        >
                            <x-icons.fine class="w-5 h-5" />

                            <span class="mx-2 text-sm font-medium" x-show="$store.sidebar.on">Multas</span>
                        </a>
                    @endcan

                    @can('viewAny', App\Models\User::class)
                        <a
                            class="flex items-center px-3 py-2 text-gray-600 transform rounded-lg dark:text-gray-200 hover:bg-gray-100
                                dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700
                                {{ request()->routeIs('back.users.*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                            x-data="{ tooltip: ! $store.sidebar.on ? 'Usuarios' : false }"
                            x-init="$watch('$store.sidebar.on', value => tooltip = ! value ? 'Usuarios' : false )"
                            x-tooltip.placement.right.delay.50="tooltip"
                            href="{{ route('back.users.index') }}"
                            wire:navigate
                        >
                            <x-icons.users class="w-5 h-5" />

                            <span class="mx-2 text-sm font-medium" x-show="$store.sidebar.on">Usuarios</span>
                        </a>
                    @endcan

                    @can('viewAny', App\Models\Copy::class)
                        <a
                            class="flex items-center px-3 py-2 text-gray-600 transform rounded-lg dark:text-gray-200 hover:bg-gray-100
                                dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700
                                {{ request()->routeIs('back.copies.*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                            x-data="{ tooltip: ! $store.sidebar.on ? 'Copias' : false }"
                            x-init="$watch('$store.sidebar.on', value => tooltip = ! value ? 'Copias' : false )"
                            x-tooltip.placement.right.delay.50="tooltip"
                            href="{{ route('back.copies.index') }}"
                            wire:navigate
                        >
                            <x-icons.copies class="w-5 h-5" />

                            <span class="mx-2 text-sm font-medium" x-show="$store.sidebar.on">Copias</span>
                        </a>
                    @endcan
                </div>

                <div class="space-y-3">
                    @if(auth()->user()->can('viewAny', Spatie\Permission\Models\Role::class) || auth()->user()->can('viewAny', Spatie\Permission\Models\Permission::class))
                        <label class="px-3 text-xs text-gray-500 uppercase dark:text-gray-400" x-show="$store.sidebar.on">configuración</label>
                    @endif

                    @can('viewAny', Spatie\Permission\Models\Role::class)
                        <a
                            class="flex items-center px-3 py-2 text-gray-600 transform rounded-lg dark:text-gray-200 hover:bg-gray-100
                                dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700
                                {{ request()->routeIs('back.roles.*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                            x-data="{ tooltip: ! $store.sidebar.on ? 'Roles' : false }"
                            x-init="$watch('$store.sidebar.on', value => tooltip = ! value ? 'Roles' : false )"
                            x-tooltip.placement.right.delay.50="tooltip"
                            href="{{ route('back.roles.index') }}"
                            wire:navigate
                        >
                            <x-icons.role class="w-5 h-5" />

                            <span class="mx-2 text-sm font-medium" x-show="$store.sidebar.on">Roles</span>
                        </a>
                    @endcan

                    @can('viewAny', Spatie\Permission\Models\Permission::class)
                        <a
                            class="flex items-center px-3 py-2 text-gray-600 transform rounded-lg dark:text-gray-200 hover:bg-gray-100
                                dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700
                                {{ request()->routeIs('back.permissions.*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                            x-data="{ tooltip: ! $store.sidebar.on ? 'Permisos' : false }"
                            x-init="$watch('$store.sidebar.on', value => tooltip = ! value ? 'Permisos' : false )"
                            x-tooltip.placement.right.delay.50="tooltip"
                            href="{{ route('back.permissions.index') }}"
                            wire:navigate
                        >
                            <x-icons.permission class="w-5 h-5" />

                            <span class="mx-2 text-sm font-medium" x-show="$store.sidebar.on">Permisos</span>
                        </a>
                    @endcan
                </div>

                <div class="space-y-3">
                    @if(
                        auth()->user()->can('viewAny', App\Models\Edition::class) ||
                        auth()->user()->can('viewAny', App\Models\Editorial::class) ||
                        auth()->user()->can('viewAny', App\Models\Book::class) ||
                        auth()->user()->can('viewAny', App\Models\Author::class) ||
                        auth()->user()->can('viewAny', App\Models\Genre::class)
                    )
                        <label class="px-3 text-xs text-gray-500 uppercase dark:text-gray-400" x-show="$store.sidebar.on">datos</label>
                    @endif

                    @can('viewAny', App\Models\Edition::class)
                        <a
                            class="flex items-center px-3 py-2 text-gray-600 transform rounded-lg dark:text-gray-200 hover:bg-gray-100
                                dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700
                                {{ request()->routeIs('back.editions.*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                            x-data="{ tooltip: ! $store.sidebar.on ? 'Ediciones' : false }"
                            x-init="$watch('$store.sidebar.on', value => tooltip = ! value ? 'Ediciones' : false )"
                            x-tooltip.placement.right.delay.50="tooltip"
                            href="{{ route('back.editions.index') }}"
                            wire:navigate
                        >
                            <x-icons.edition class="w-5 h-5" />

                            <span class="mx-2 text-sm font-medium" x-show="$store.sidebar.on">Ediciones</span>
                        </a>
                    @endcan

                    @can('viewAny', App\Models\Editorial::class)
                        <a
                            class="flex items-center px-3 py-2 text-gray-600 transform rounded-lg dark:text-gray-200 hover:bg-gray-100
                                dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700
                                {{ request()->routeIs('back.editorials.*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                            x-data="{ tooltip: ! $store.sidebar.on ? 'Editoriales' : false }"
                            x-init="$watch('$store.sidebar.on', value => tooltip = ! value ? 'Editoriales' : false )"
                            x-tooltip.placement.right.delay.50="tooltip"
                            href="{{ route('back.editorials.index') }}"
                            wire:navigate
                        >
                            <x-icons.editorial class="w-5 h-5" />

                            <span class="mx-2 text-sm font-medium" x-show="$store.sidebar.on">Editoriales</span>
                        </a>
                    @endcan

                    @can('viewAny', App\Models\Book::class)
                        <a
                            class="flex items-center px-3 py-2 text-gray-600 transform rounded-lg dark:text-gray-200 hover:bg-gray-100
                                dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700
                                {{ request()->routeIs('back.books.*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                            x-data="{ tooltip: ! $store.sidebar.on ? 'Libros' : false }"
                            x-init="$watch('$store.sidebar.on', value => tooltip = ! value ? 'Libros' : false )"
                            x-tooltip.placement.right.delay.50="tooltip"
                            href="{{ route('back.books.index') }}"
                            wire:navigate
                        >
                            <x-icons.book class="w-5 h-5" />

                            <span class="mx-2 text-sm font-medium" x-show="$store.sidebar.on">Libros</span>
                        </a>
                    @endcan

                    @can('viewAny', App\Models\Author::class)
                        <a
                            class="flex items-center px-3 py-2 text-gray-600 transform rounded-lg dark:text-gray-200 hover:bg-gray-100
                                dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700
                                {{ request()->routeIs('back.authors.*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                            x-data="{ tooltip: ! $store.sidebar.on ? 'Autores' : false }"
                            x-init="$watch('$store.sidebar.on', value => tooltip = ! value ? 'Autores' : false )"
                            x-tooltip.placement.right.delay.50="tooltip"
                            href="{{ route('back.authors.index') }}"
                            wire:navigate
                        >
                            <x-icons.author class="w-5 h-5" />

                            <span class="mx-2 text-sm font-medium" x-show="$store.sidebar.on">Autores</span>
                        </a>
                    @endcan

                    @can('viewAny', App\Models\Genre::class)
                        <a
                            class="flex items-center px-3 py-2 text-gray-600 transform rounded-lg dark:text-gray-200 hover:bg-gray-100
                                dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700
                                {{ request()->routeIs('back.genres.*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                            x-data="{ tooltip: ! $store.sidebar.on ? 'Géneros' : false }"
                            x-init="$watch('$store.sidebar.on', value => tooltip = ! value ? 'Géneros' : false )"
                            x-tooltip.placement.right.delay.50="tooltip"
                            href="{{ route('back.genres.index') }}"
                            wire:navigate
                        >
                            <x-icons.genre class="w-5 h-5" />

                            <span class="mx-2 text-sm font-medium" x-show="$store.sidebar.on">Géneros</span>
                        </a>
                    @endcan
                </div>
            </nav>
        </div>
    </div>
</aside>
