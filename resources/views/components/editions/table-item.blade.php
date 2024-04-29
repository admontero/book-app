<tr wire:key="edition-{{ $edition->id }}">
    <td class="max-w-48 px-4 py-4 text-sm font-medium whitespace-nowrap">
        <h2 class="font-medium text-gray-800 dark:text-white truncate first-letter:uppercase">{{ $edition->book?->title }}</h2>
        @if ($edition->year)
            <span class="hidden lg:block font-normal text-gray-600 dark:text-gray-400 truncate">
                {{ $edition->year }}
            </span>
        @endif
        <dl class="lg:hidden">
            <dt class="sr-only">Editorial</dt>
            <dd class="font-normal text-gray-600 dark:text-gray-400 truncate capitalize">
                @if ($edition->editorial_id)
                    {{ $edition->editorial->name }}
                @else
                    <span class="italic text-xs">editorial desconocida</span>
                @endif
            </dd>
            <dt class="sr-only">Año</dt>
            <dd class="font-normal text-gray-600 dark:text-gray-400 truncate">
                @if ($edition->year)
                    {{ $edition->year }}
                @endif
            </dd>
        </dl>
    </td>

    <td class="hidden lg:table-cell px-4 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-400 capitalize">
        @if ($edition->editorial_id)
            {{ $edition->editorial->name }}
        @else
            <span class="italic text-xs">desconocido</span>
        @endif
    </td>

    <td class="max-w-0 sm:max-w-40 px-4 py-4 text-xs sm:text-sm whitespace-nowrap text-gray-700 dark:text-gray-400">
        @if ($edition->isbn13)
            {{ $edition->isbn13 }}
        @else
            <span class="italic text-xs">desconocido</span>
        @endif
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
                        href="{{ route('back.editions.edit', $edition) }}"
                        class="flex w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600
                            focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-600 transition duration-150 ease-in-out"
                        @click="show = false"
                        wire:navigate
                    >
                        <x-icons.edit class="w-5 h-5 me-2" />
                        Editar Edición
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
