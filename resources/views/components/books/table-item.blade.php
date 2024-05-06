<tr wire:key="book-{{ $book->id }}">
    <td class="max-w-48 px-4 py-4 text-sm font-medium whitespace-nowrap">
        <h2 class="font-medium text-gray-800 dark:text-white truncate first-letter:uppercase">{{ $book->title }}</h2>
        <dl>
            <dt class="sr-only">Año de Publicación</dt>
            <dd class="font-normal text-gray-600 dark:text-gray-400 truncate">
                @if ($book->publication_year)
                    {{ $book->publication_year }}
                @endif
            </dd>
            <dt class="sr-only lg:hidden">Autor</dt>
            <dd class="font-normal text-gray-600 dark:text-gray-400 truncate lg:hidden capitalize">
                @if ($book->author_id)
                    {{ $book->author->name }}
                @else
                    <span class="italic text-xs">autor desconocido</span>
                @endif
            </dd>
        </dl>
    </td>

    <td class="hidden lg:table-cell px-4 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-400 capitalize">
        @if ($book->author_id)
            {{ $book->author->name }}
        @else
            <span class="italic text-xs">desconocido</span>
        @endif
    </td>

    <td
        class="max-w-0 sm:max-w-40 px-4 py-4 text-sm whitespace-nowrap"
        x-data="{
            show: false,
            search: '',
            genres: {{ Illuminate\Support\Js::from($book->genres) }},
            get genresFiltered() {
                if (! this.search.length) return this.genres

                return this.genres.filter(genre => latinize(genre.name.toLowerCase()).includes(latinize(this.search.toLowerCase())))
            },
        }"
    >
        <div>
            <div class="line-clamp-1">
                @if ($book->genres->count())
                    <p
                        class="text-gray-700 dark:text-gray-400 truncate"
                        x-text="genres.map(genre => genre.name.charAt(0).toUpperCase() + genre.name.slice(1)).join(', ')"
                    ></p>
                @else
                    <p class="text-xs italic">Sin géneros asignados</p>
                @endif
            </div>

            <x-dropdown-floating width="w-72" position="bottom-start">
                <x-slot name="trigger">
                    <button
                        class="mt-1 underline underline-offset-2 text-indigo-400 dark:text-indigo-300 text-xs font-medium"
                        x-init="$watch('show', value => $nextTick(() => { if (value) $refs.search.focus() }))"
                        @click="search = ''"
                    >
                        Ver todos
                    </button>
                </x-slot>

                <x-slot name="content">
                    <div class="px-3 pt-3 mb-1">
                        <x-input x-ref="search" class="w-full" type="search" x-model="search" />
                    </div>

                    <div class="max-h-52 overflow-y-auto">
                        <template x-if="genres.length">
                            <div>
                                <div class="sticky top-0 text-sm font-medium text-gray-600 dark:text-gray-300 px-3 py-2 bg-white
                                    dark:bg-gray-800 border-b dark:border-gray-600"
                                >
                                    Géneros
                                    (<span x-text="genresFiltered.length"></span>)
                                </div>

                                <ul>
                                    <template x-for="(genre, i) in genresFiltered" :key="genre.id">
                                        <li
                                            class="px-5 py-2 truncate text-gray-500 dark:text-gray-400 first-letter:uppercase"
                                            :class="i % 2 === 0 && 'bg-gray-50 dark:bg-gray-900'"
                                            x-text="genre.name"
                                        ></li>
                                    </template>
                                </ul>

                                <template x-if="genres.length && ! genresFiltered.length && search.length">
                                    <div class="text-gray-400 italic text-xs text-center py-3">
                                        No hay coincidencias con su búsqueda.
                                    </div>
                                </template>
                            </div>
                        </template>

                        <template x-if="! genres.length">
                            <p class="text-gray-400 italic text-xs text-center py-3">
                                No hay géneros asignados.
                            </p>
                        </template>
                    </div>
                </x-slot>
            </x-dropdown-floating>
        </div>
    </td>

    <td class="px-4 py-4 text-sm whitespace-nowrap">
        <div class="flex justify-center gap-2 items-center">
            <x-dropdown-floating position="left-start">
                <x-slot name="trigger">
                    <button
                        class="p-2 rounded-md bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-600 hover:text-gray-900
                        dark:text-white dark:hover:text-gray-300 border border-gray-200 dark:border-gray-600 focus:outline-none shadow"
                        x-tooltip.raw="Opciones"
                    >
                        <x-icons.dots-vertical class="w-5 h-5" />
                    </button>
                </x-slot>

                <x-slot name="content">
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        Opciones
                    </div>

                    <a
                        href="{{ route('back.books.edit', $book) }}"
                        class="flex w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600
                            focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-600 transition duration-150 ease-in-out"
                        @click="show = false"
                        wire:navigate
                    >
                        <x-icons.edit class="w-5 h-5 me-2" />
                        Editar Libro
                    </a>
                </x-slot>
            </x-dropdown-floating>

            <a
                class="p-2 rounded-md bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-600 hover:text-gray-900
                dark:text-white dark:hover:text-gray-300 border border-gray-200 dark:border-gray-600 shadow"
                href="#"
                x-tooltip.raw="Ver"
                wire:navigate
            >
                <x-icons.show class="w-5 h-5" />
            </a>
        </div>
    </td>
</tr>
