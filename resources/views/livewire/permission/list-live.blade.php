<section class="max-w-7xl px-4 mx-auto">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center gap-x-3">
                <h2 class="text-xl font-medium text-gray-800 dark:text-white">Permisos</h2>

                <span class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full dark:bg-gray-800 dark:text-blue-400">{{ $this->permissionsCount }} permisos</span>
            </div>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                Gestiona todos los permisos registrados en el sistema. Como administrador
                podrás visualizar los permisos existentes. Además de la posibilidad de
                poder asignarlos a un usuario o rol en específico.
            </p>
        </div>
    </div>

    <div class="mt-4 md:flex md:items-center md:justify-between">
        <div></div>

        <div class="flex-1 flex justify-end items-center mt-4 md:mt-0">
            <x-search-input
                class="max-w-96 w-full"
                placeholder="Buscar permiso..."
                wire:model.live.debounce.500ms="search"
            />
        </div>
    </div>

    @if ($permissions->count())
        <x-table-container class="mt-4" wire:key="permission-list">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <x-table-header-cell value="Nombre" sortableFor="name" :$sortField :$sortDirection />

                    <x-table-header-cell class="hidden lg:table-cell" value="Usuarios" />

                    <x-table-header-cell value="Roles" />

                    <th scope="col" class="relative px-4 py-3.5">
                        <span class="sr-only">Edit</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                @foreach ($permissions as $permission)
                    <x-permissions.table-item :$permission />
                @endforeach
            </tbody>
        </x-table-container>
    @else
        <x-table-empty title="Ningún permiso encontrado" wire:key="permission-list-empty">
            <x-alternative-button wire:click="$set('search', '')">Limpiar Buscador</x-alternative-button>
        </x-table-empty>
    @endif

    <div class="mt-4">
        {{ $permissions->links('vendor.livewire.custom') }}
    </div>
</section>

