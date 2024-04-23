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
                        class="mt-1 underline underline-offset-2 text-[#7F9CF5] text-xs dark:text-white font-medium"
                        x-init="$watch('show', value => $nextTick(() => { if (value) $refs.search.focus() }))"
                        @click="search = ''"
                    >
                        Ver todos
                    </button>
                </x-slot>

                <x-slot name="content">
                    <div class="px-3 pt-3">
                        <x-input x-ref="search" class="w-full" type="search" x-model="search" />
                    </div>

                    <div class="max-h-52 overflow-y-auto">
                        <template x-if="genres.length">
                            <div>
                                <p class="text-xs text-gray-400 px-3 mt-2 mb-1">
                                    <span x-text="genresFiltered.length"></span>
                                    género(s)
                                </p>

                                <ul>
                                    <template x-for="genre in genresFiltered" :key="genre.id">
                                        <li x-text="genre.name" class="px-5 py-1.5 truncate text-gray-600 dark:text-gray-300 first-letter:uppercase"></li>
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
                        <svg class="icon icon-tabler icon-tabler-dots-vertical w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /></svg>
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
                        <svg class="icon icon-tabler icon-tabler-edit w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
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
                <svg class="icon icon-tabler icon-tabler-eye-up w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M12 18c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6c-.09 .15 -.18 .295 -.27 .439" /><path d="M19 22v-6" /><path d="M22 19l-3 -3l-3 3" /></svg>
            </a>
        </div>
    </td>
</tr>
