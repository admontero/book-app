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
        <x-button-group>
            <x-button-group-item
                :selected="! count($this->rolesArray)"
                wire:click="$set('roles', '')"
            >
                Ver todos
            </x-button-group-item>

            @foreach ($this->allRoles as $id => $name)
                <x-button-group-item
                    :selected="in_array($name, $this->rolesArray)"
                    wire:click="setRoles('{{ $name }}')"
                    wire:key="button-role-{{ $id }}"
                >
                    {{ App\Enums\RoleEnum::options()[$name] }}
                </x-button-group-item>
            @endforeach
        </x-button-group>

        <div class="flex-1 flex justify-end items-center mt-4 md:mt-0">
            <x-search-input
                class="max-w-96 w-full"
                placeholder="Buscar usuario..."
                wire:model.live.debounce.500ms="search"
            />
        </div>
    </div>

    @if ($users->count())
        <x-table-container class="mt-4" wire:key="user-list">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <x-table-header-cell value="Nombre" sortableFor="name" :$sortField :$sortDirection />

                    <x-table-header-cell class="hidden xl:table-cell" value="Email" sortableFor="email" :$sortField :$sortDirection />

                    <x-table-header-cell class="hidden lg:table-cell" value="Rol" sortableFor="roles.name" :$sortField :$sortDirection />

                    <x-table-header-cell value="Permisos" />

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
        </x-table-container>
    @else
        <x-table-empty title="Ningún usuario encontrado" wire:key="user-list-empty">
            <x-alternative-button wire:click="$set('search', '')">Limpiar Buscador</x-alternative-button>
        </x-table-empty>
    @endif

    <div class="mt-4">
        {{ $users->links('vendor.livewire.custom') }}
    </div>
</section>
