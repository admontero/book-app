<tr wire:key="editorial-{{ $editorial->id }}">
    <td class="max-w-0 sm:max-w-none px-4 py-4 text-sm font-medium whitespace-nowrap">
        <h2 class="font-medium text-gray-800 dark:text-white capitalize truncate">{{ $editorial->name }}</h2>
    </td>

    <td class="px-4 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-400">
        {{ $editorial->slug }}
    </td>

    <td class="px-4 py-4 text-sm whitespace-nowrap">
        <div class="flex justify-center gap-2 items-center">
            <div x-ref="editorial_{{ $editorial->id }}">
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

                        <button
                            class="flex w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100
                                dark:hover:bg-gray-600 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-600 transition duration-150 ease-in-out"
                            wire:click="setEditorial('{{ $editorial->id }}')"
                            @click="$dispatch('set-edit-editorial-{{ $editorial->id }}'); show = false;"
                        >
                            <x-icons.edit class="w-5 h-5 me-2" />
                            Editar editorial
                        </button>
                    </x-slot>
                </x-dropdown-floating>

                <x-editorials.edit :$editorial />
            </div>

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
