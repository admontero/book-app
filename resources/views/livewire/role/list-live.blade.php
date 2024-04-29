<section class="max-w-7xl px-4 mx-auto">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center gap-x-3">
                <h2 class="text-xl font-medium text-gray-800 dark:text-white">Roles</h2>

                <span class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full dark:bg-gray-800 dark:text-blue-400">{{ $this->rolesCount }} roles</span>
            </div>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                Gestiona todos los roles registrados en el sistema. Como administrador
                podrás visualizar los roles existentes, además de tener la posibilidad de
                asignar los permisos a estos según se requiera.
            </p>
        </div>
    </div>

    <div class="mt-4 md:flex md:items-center md:justify-between">
        <div></div>

        <div class="flex-1 flex justify-end items-center mt-4 md:mt-0">
            <div class="relative max-w-96 w-full">
                <span class="absolute top-2.5">
                    <x-icons.search class="w-5 h-5 mx-3 text-gray-400 dark:text-gray-500" />
                </span>

                <x-input
                    class="pl-11 w-full"
                    type="search"
                    placeholder="Buscar rol..."
                    wire:model.live.debounce.500ms="search"
                />
            </div>
        </div>
    </div>

    @if ($roles->count())
        <div class="flex flex-col mt-4">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-2 lg:-mx-4">
                <div class="inline-block min-w-full py-2 align-middle md:px-2 lg:px-4">
                    <div class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th scope="col" class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <button
                                            class="flex items-center gap-x-3 focus:outline-none @if ($sortField == 'name') font-medium text-gray-800 dark:text-white @endif"
                                            wire:click="sortBy('name')"
                                        >
                                            <span>Nombre</span>

                                            @if ($sortDirection === 'asc')
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-sort-ascending-letters w-5 h-5" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 10v-5c0 -1.38 .62 -2 2 -2s2 .62 2 2v5m0 -3h-4" /><path d="M19 21h-4l4 -7h-4" /><path d="M4 15l3 3l3 -3" /><path d="M7 6v12" /></svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-sort-descending-letters w-5 h-5" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 21v-5c0 -1.38 .62 -2 2 -2s2 .62 2 2v5m0 -3h-4" /><path d="M19 10h-4l4 -7h-4" /><path d="M4 15l3 3l3 -3" /><path d="M7 6v12" /></svg>
                                            @endif
                                        </button>
                                    </th>

                                    <th scope="col" class="hidden lg:table-cell px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Usuarios
                                    </th>

                                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Permisos
                                    </th>

                                    <th scope="col" class="relative py-3.5 px-4">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                                @foreach ($roles as $role)
                                    <x-roles.table-item :$role />
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @else
    <x-table-empty title="Ningún rol encontrado" />
    @endif

    {{ $roles->links('vendor.livewire.custom') }}
</section>
