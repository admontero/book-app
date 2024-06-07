<tr wire:key="author-{{ $author->id }}">
    <td class="flex items-center px-4 py-4 text-sm font-medium whitespace-nowrap">
        <img class="object-cover w-10 h-10 rounded-full" src="{{ $author->photo_url }}" alt="foto de {{ $author->full_name }}">
        <div class="ml-2">
            <h2 class="font-medium text-gray-800 dark:text-white truncate capitalize">{{ $author->full_name }}</h2>
            @if ($author->country_birth_id)
                <dl class="lg:hidden">
                    <dt class="sr-only">País</dt>
                    <dd class="font-normal text-gray-600 dark:text-gray-400 truncate">
                        {{ __('world::country.' . $author->country_birth->iso2) }}
                    </dd>
                </dl>
            @endif
        </div>
    </td>

    <td class="hidden lg:table-cell px-4 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-400">
        @if ($author->country_birth_id)
            <div>
                <span class="mr-2 fi fi-{{ strtolower($author->country_birth->iso2) }}"></span>
                {{ __('world::country.' . $author->country_birth->iso2) }}
            </div>
        @else
            <span class="italic text-xs">Desconocido</span>
        @endif
    </td>

    <td class="px-4 py-4 text-sm whitespace-nowrap">
        <div class="flex justify-center gap-2 items-center">
            <x-dropdown-floating position="left-start" wire:ignore>
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
                        href="{{ route('back.authors.edit', $author) }}"
                        class="flex w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600
                            focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-600 transition duration-150 ease-in-out"
                        @click="show = false"
                        wire:navigate
                    >
                        <x-icons.edit class="w-5 h-5 me-2" />
                        Editar Autor
                    </a>
                </x-slot>
            </x-dropdown-floating>

            <a
                class="p-2 rounded-md bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-600 hover:text-gray-900
                dark:text-white dark:hover:text-gray-300 border border-gray-200 dark:border-gray-600 shadow"
                href="{{ route('back.authors.show', $author) }}"
                x-tooltip.raw="Ver"
                wire:navigate
            >
                <x-icons.show class="w-5 h-5" />
            </a>
        </div>
    </td>
</tr>
