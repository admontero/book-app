<tr wire:key="genre-{{ $genre->id }}">
    <td class="max-w-0 sm:max-w-none px-4 py-4 text-sm font-medium whitespace-nowrap">
        <h2 class="font-medium text-gray-800 dark:text-white capitalize truncate">{{ $genre->name }}</h2>
    </td>

    <td class="px-4 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-400">
        {{ $genre->slug }}
    </td>

    <td class="px-4 py-4 text-sm whitespace-nowrap">
        <div class="flex justify-center gap-2 items-center">
            <div x-ref="genre_{{ $genre->id }}">
                <x-dropdown-floating position="left-start" wire:ignore>
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

                        <button
                            class="flex w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100
                                dark:hover:bg-gray-600 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-600 transition duration-150 ease-in-out"
                            wire:click="setGenre('{{ $genre->id }}')"
                            @click="$dispatch('set-edit-genre-{{ $genre->id }}'); show = false;"
                        >
                            <svg class="icon icon-tabler icon-tabler-edit w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                            Editar género
                        </button>
                    </x-slot>
                </x-dropdown-floating>

                <x-genres.edit :$genre />
            </div>

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
