<div class="w-full p-2 sm:p-6" x-data="{ expanded: true }">
    <div class="flex items-center justify-between">
        <div class="flex">
            <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Géneros</h5>
            @if (count($value))
                <button
                    class="ms-2 text-sm font-medium text-blue-600 hover:underline dark:text-blue-500"
                    wire:click="$parent.resetFilter('genres', [])"
                    @click="$wire.search = ''"
                >
                    &times; Limpiar todos
                </button>
            @endif
        </div>

        <button @click="expanded = ! expanded">
            <svg
                class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-down w-5 h-5 font-semibold text-blue-600 dark:text-blue-500
                    transition-all duration-150 ease-in-out"
                :class="expanded && 'rotate-180'"
                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9l6 6l6 -6" /></svg>
        </button>
    </div>

    @if (count($value))
        <div class="mt-3">
            @foreach ($value as $item)
                <span wire:key="genre-selected-{{ $item }}" class="mb-1 inline-flex items-center px-2 py-1 me-2 text-sm font-medium capitalize text-blue-800 bg-blue-100 rounded dark:bg-blue-900 dark:text-blue-300">
                    {{ $this->genre($item)?->name }}
                    <button wire:click="$parent.remove('genres', {{ $item }})" type="button" class="inline-flex items-center p-1 ms-2 text-sm text-blue-400 bg-transparent rounded-sm hover:bg-blue-200 hover:text-blue-900 dark:hover:bg-blue-800 dark:hover:text-blue-300" data-dismiss-target="#badge-dismiss-default" aria-label="Remove">
                        <svg class="w-2 h-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Remove badge</span>
                    </button>
                </span>
            @endforeach
        </div>
    @endif

    <div class="mt-4" x-show="expanded" x-collapse>
        <x-input
            class="w-full"
            type="search"
            wire:model.live.debounce.300ms="search"
        />

        @if ($this->genres->count())
            <div class="max-h-52 overflow-y-auto space-y-1 px-2 mt-3">
                @foreach ($this->genres as $genre)
                    <div wire:key="filters-genre-{{ $genre->id }}">
                        <label class="inline-flex items-center cursor-pointer">
                            <x-checkbox wire:model="value" value="{{ $genre->id }}" />

                            <p class="ms-3 text-gray-700 dark:text-gray-300 capitalize">
                                {{ $genre->name }}
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium ms-2 px-2 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">
                                    {{ $genre->editions_count }}
                                </span>
                            </p>
                        </label>
                    </div>
                @endforeach
            </div>
        @else
            <div class="mt-4">
                @if ($this->search)
                    <p class="italic text-sm text-center dark:text-gray-400">No hay coincidencias con su búsqueda.</p>
                @else
                    <p class="italic text-sm text-center dark:text-gray-400">No hay géneros disponibles.</p>
                @endif
            </div>
        @endif
    </div>
</div>
