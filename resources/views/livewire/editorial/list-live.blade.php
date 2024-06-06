<section class="max-w-7xl px-4 mx-auto">
    <div class="md:flex md:items-center md:justify-between md:gap-x-4">
        <div class="flex-1">
            <div class="flex items-center gap-x-3">
                <h2 class="text-xl font-medium text-gray-800 dark:text-white">Editoriales</h2>

                <span class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full dark:bg-gray-800 dark:text-blue-400">{{ $this->editorialsCount }} editoriales</span>
            </div>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                Gestiona todos las editoriales registradas en el sistema. Podrás visualizar las editoriales existentes.
                Además podrás agregar nuevas editoriales según lo requieras.
            </p>
        </div>

        <div class="flex shrink-0 items-center justify-end mt-4">
            <x-editorials.create />
        </div>
    </div>

    <div class="mt-6 md:flex md:flex-wrap md:gap-4 md:items-center md:justify-between">
        <div></div>

        <div class="flex-1 flex justify-end items-center mt-4 md:mt-0">
            <x-search-input
                class="max-w-96 w-full"
                placeholder="Buscar editorial..."
                wire:model.live.debounce.500ms="search"
            />
        </div>
    </div>

    @if ($this->editorials->count())
        <x-table-container class="mt-4" wire:key="editorial-list">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <x-table-header-cell value="Nombre" sortableFor="name" :$sortColumn :$sortDirection />

                    <x-table-header-cell value="Slug" sortableFor="slug" :$sortColumn :$sortDirection />

                    <th scope="col" class="relative px-4 py-3.5">
                        <span class="sr-only">Edit</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                @foreach ($this->editorials as $editorial)
                    <x-editorials.table-item :$editorial />
                @endforeach
            </tbody>
        </x-table-container>
    @else
        <x-table-empty title="Ningún editorial encontrado" wire:key="editorial-list-empty">
            <x-alternative-button wire:click="$set('search', '')">Limpiar Buscador</x-alternative-button>
        </x-table-empty>
    @endif

    <div class="mt-4">
        {{ $this->editorials->links('vendor.livewire.custom') }}
    </div>
</section>

