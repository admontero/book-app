<section class="max-w-7xl px-4 mx-auto">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center gap-x-3">
                <h2 class="text-xl font-medium text-gray-800 dark:text-white">Ediciones</h2>

                <span class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full dark:bg-gray-800 dark:text-blue-400">{{ $this->editionsCount }} ediciones</span>
            </div>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                Gestiona todos las ediciones registrados en el sistema. Podrás visualizar las ediciones existentes.
                Además podrás agregar nuevas ediciones según lo requieras.
            </p>
        </div>
        <div class="flex shrink-0 items-center justify-end mt-4">
            <a
                class="flex items-center justify-center px-5 py-2 text-sm tracking-wide text-white transition-colors duration-200 bg-blue-500 rounded-lg
                    sm:w-auto gap-x-2 hover:bg-blue-600 dark:hover:bg-blue-500 dark:bg-blue-600"
                href="{{ route('back.editions.create') }}"
                wire:navigate
            >
                <x-icons.add class="w-5 h-5" />

                <span>Nueva</span>
            </a>
        </div>
    </div>

    <div class="mt-6 md:flex md:flex-wrap md:gap-4 md:items-center md:justify-between">
        <div></div>

        <div class="flex-1 flex justify-end items-center mt-4 md:mt-0">
            <x-search-input
                class="max-w-96 w-full"
                placeholder="Buscar edición..."
                wire:model.live.debounce.500ms="search"
            />
        </div>
    </div>

    @if ($editions->count())
        <x-table-container class="mt-4" wire:key="edition-list">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <x-table-header-cell value="Libro" sortableFor="books.title" :$sortField :$sortDirection />

                    <x-table-header-cell value="Editorial" sortableFor="editorials.name" :$sortField :$sortDirection />

                    <x-table-header-cell value="ISBN13" />

                    <th scope="col" class="relative px-4 py-3.5">
                        <span class="sr-only">Edit</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                @foreach ($editions as $edition)
                    <x-editions.table-item :$edition />
                @endforeach
            </tbody>
        </x-table-container>
    @else
        <x-table-empty title="Ningún edición encontrado" wire:key="edition-list-empty">
            <x-alternative-button wire:click="$set('search', '')">Limpiar Buscador</x-alternative-button>
        </x-table-empty>
    @endif

    <div class="mt-4">
        {{ $editions->links('vendor.livewire.custom') }}
    </div>
</section>
