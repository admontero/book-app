<section class="max-w-7xl px-4 mx-auto">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center gap-x-3">
                <h2 class="text-xl font-medium text-gray-800 dark:text-white">Usuarios</h2>

                <span class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full dark:bg-gray-800 dark:text-blue-400">{{ $this->usersCount }} usuarios</span>
            </div>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                Gestiona todos los usuarios registrados en el sistema. Con ciertos roles
                podrás visualizar los usuarios existentes. Además podrás agregar
                nuevos usuarios según lo requieras.
            </p>
        </div>
    </div>

    <div class="mt-6 md:flex md:flex-wrap md:gap-4 md:items-center md:justify-between">
        <div class="inline-flex flex-col sm:flex-row w-full sm:w-auto divide-y sm:divide-y-0 overflow-hidden bg-white border sm:divide-x rounded-lg rtl:flex-row-reverse
            dark:border-gray-700 dark:divide-gray-700">
            <button
                class="px-5 py-2 text-xs font-medium text-gray-600 sm:text-sm dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-white
                    hover:bg-gray-100 {{ count($this->rolesArray) == 0 ? 'bg-gray-100 dark:bg-gray-900' : 'bg-white' }}"
                type="button"
                wire:click="$set('roles', '')"
            >
                Ver todos
            </button>

            @foreach ($this->allRoles as $id => $name)
                <button
                    class="px-5 py-2 text-xs font-medium text-gray-600 dark:bg-gray-800 sm:text-sm dark:hover:bg-gray-700
                        dark:text-gray-300 hover:bg-gray-100 {{ in_array($name, $this->rolesArray) ? 'bg-gray-100 dark:bg-gray-900' : 'bg-white' }}"
                    type="button"
                    wire:click="setRoles('{{ $name }}')"
                    wire:key="button-role-{{ $id }}"
                >
                    {{ App\Enums\RoleEnum::options()[$name] }}
                </button>
            @endforeach
        </div>

        <div class="relative flex items-center mt-4 md:mt-0">
            <span class="absolute">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search w-5 h-5 mx-3 text-gray-400 dark:text-gray-600" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
            </span>

            <x-input
                class="pl-11"
                type="search"
                placeholder="Buscar usuario..."
                wire:model.live.debounce.500ms="search"
            />
        </div>
    </div>

    @if ($users->count())
        <div class="flex flex-col mt-4" wire:key="user-list">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-2 lg:-mx-4">
                <div class="inline-block min-w-full py-2 align-middle md:px-2 lg:px-4">
                    <div class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th scope="col" class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <button
                                            class="flex items-center gap-x-3 focus:outline-none @if ($sortField == 'name') font-medium text-gray-800 dark:text-white @endif"
                                            type="button"
                                            wire:click="sortBy('name')"
                                        >
                                            <span>Nombre</span>

                                            @if ($sortField == 'name' && $sortDirection === 'desc')
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-sort-descending-letters w-5 h-5" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 21v-5c0 -1.38 .62 -2 2 -2s2 .62 2 2v5m0 -3h-4" /><path d="M19 10h-4l4 -7h-4" /><path d="M4 15l3 3l3 -3" /><path d="M7 6v12" /></svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-sort-ascending-letters w-5 h-5" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 10v-5c0 -1.38 .62 -2 2 -2s2 .62 2 2v5m0 -3h-4" /><path d="M19 21h-4l4 -7h-4" /><path d="M4 15l3 3l3 -3" /><path d="M7 6v12" /></svg>
                                            @endif
                                        </button>
                                    </th>

                                    <th scope="col" class="hidden xl:table-cell py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <button
                                            class="flex items-center gap-x-3 focus:outline-none @if ($sortField == 'email') font-medium text-gray-800 dark:text-white @endif"
                                            type="button"
                                            wire:click="sortBy('email')"
                                        >
                                            <span>Email</span>

                                            @if ($sortField == 'email' && $sortDirection === 'desc')
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-sort-descending-letters w-5 h-5" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 21v-5c0 -1.38 .62 -2 2 -2s2 .62 2 2v5m0 -3h-4" /><path d="M19 10h-4l4 -7h-4" /><path d="M4 15l3 3l3 -3" /><path d="M7 6v12" /></svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-sort-ascending-letters w-5 h-5" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 10v-5c0 -1.38 .62 -2 2 -2s2 .62 2 2v5m0 -3h-4" /><path d="M19 21h-4l4 -7h-4" /><path d="M4 15l3 3l3 -3" /><path d="M7 6v12" /></svg>
                                            @endif
                                        </button>
                                    </th>

                                    <th scope="col" class="hidden lg:table-cell px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Rol
                                    </th>

                                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Permisos
                                    </th>

                                    <th scope="col" class="relative px-4 py-3.5">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                                @foreach ($users as $user)
                                    <x-users.table-item :$user />
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="flex items-center mt-6 text-center border rounded-lg h-96 dark:border-gray-700" wire:key="user-list-empty">
            <div class="flex flex-col w-full max-w-sm px-4 mx-auto">
                <div class="p-3 mx-auto text-blue-500 bg-blue-100 rounded-full dark:bg-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search w-6 h-6" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                </div>
                <h1 class="mt-3 text-lg text-gray-800 dark:text-white">Ningún usuario encontrado</h1>
                <p class="mt-2 text-gray-500 dark:text-gray-400">La búsqueda no halló coincidencias con nuestros registros. Inténtalo de nuevo por favor.</p>
                <div class="flex items-center justify-center mt-4 sm:mx-auto gap-x-3">
                    <button
                        class="w-1/2 px-5 py-2 text-sm text-gray-700 transition-colors duration-200 bg-white border rounded-lg sm:w-auto
                            dark:hover:bg-gray-800 dark:bg-gray-900 hover:bg-gray-100 dark:text-gray-200 dark:border-gray-700"
                        type="button"
                        wire:click="$set('search', '')"
                    >
                        Limpiar Buscador
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{ $users->links('vendor.livewire.custom') }}
</section>
