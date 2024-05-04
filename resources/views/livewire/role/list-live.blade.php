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
            <x-search-input
                class="max-w-96 w-full"
                placeholder="Buscar rol..."
                wire:model.live.debounce.500ms="search"
            />
        </div>
    </div>

    @if ($roles->count())
        <x-table-container class="mt-4" wire:key="role-list">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <x-table-header-cell value="Nombre" sortableFor="name" :$sortField :$sortDirection />

                    <x-table-header-cell class="hidden lg:table-cell" value="Usuarios" />

                    <x-table-header-cell value="Permisos" />

                    <th scope="col" class="relative px-4 py-3.5">
                        <span class="sr-only">Edit</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                @foreach ($roles as $role)
                    <x-roles.table-item :$role />
                @endforeach
            </tbody>
        </x-table-container>
    @else
        <x-table-empty title="Ningún rol encontrado" wire:key="role-list-empty">
            <x-alternative-button wire:click="$set('search', '')">Limpiar Buscador</x-alternative-button>
        </x-table-empty>
    @endif

    <div class="mt-4">
        {{ $roles->links('vendor.livewire.custom') }}
    </div>
</section>
