<div class="flex justify-between gap-4">
    <div class="hidden md:block w-[300px] xl:w-[400px] px-4">
        <div class="bg-white dark:bg-gray-800 rounded-md">
            <livewire:front.filters.genre-filter-live wire:model.change="filters.genres" />

            <hr class="mx-4 dark:border-gray-700">

            <livewire:front.filters.editorial-filter-live wire:model.change="filters.editorials" />

            <hr class="mx-4 dark:border-gray-700">

            <livewire:front.filters.author-filter-live wire:model.change="filters.authors" />
        </div>
    </div>

    <div class="flex-1 px-2 sm:px-4">
        <div class="lg:flex lg:flex-wrap lg:gap-4 lg:items-center lg:justify-between">
            <div>
                <p class="text-gray-600 dark:text-gray-300">
                    <span class="text-blue-600 dark:text-blue-400 font-medium">{{ $editions->total() }}</span> Resultados
                </p>
            </div>

            <div class="flex-1 mt-4 lg:mt-0">
                <div class="flex justify-end">
                    <x-input
                        class="max-w-96 w-full"
                        type="search"
                        wire:model.live.debounce.500ms="filters.search"
                        placeholder="Buscar libro..."
                    />

                    <select
                        class="ms-4 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500
                            dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        wire:model.change="perPage"
                    >
                        @foreach ($perPageOptions as $option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        @if (count($editions))
            <div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-4 mt-4">
                    @foreach ($editions as $edition)
                        <div class="place-self-center max-w-[200px] cursor-pointer" @click="$refs.edition_{{ $edition->id }}_link.click()">
                            <img src="{{ $edition->cover_url }}" class="h-[300px] mx-auto object-cover object-center block rounded">

                            <div class="mt-4">
                                <p class="text-gray-500 text-xs tracking-widest truncate capitalize mb-1 dark:text-gray-400">
                                    {{ implode(', ', $edition->book?->genres?->pluck('name')->toArray()) }}
                                </p>

                                <h3 class="text-gray-900 text-sm font-semibold capitalize dark:text-white">
                                   <a
                                        href="{{ route('front.edition.show', $edition->slug) }}"
                                        x-ref="edition_{{ $edition->id }}_link"
                                        wire:navigate
                                    >{{ $edition->book?->title }}</a>
                                </h3>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $editions->links() }}
                </div>
            </div>
        @else
            <div class="my-4 italic text-sm text-center text-gray-600 dark:text-gray-400">
                @if ($this->isFilterEmpty())
                    <span>
                        En este momento no hay libros disponibles, inténtelo más tarde.
                    </span>
                @else
                    <span>
                        No hay libros que coincidan con su búsqueda, inténtelo con otros filtros por favor.
                    </span>
                @endif
            </div>
        @endif
    </div>
</div>
