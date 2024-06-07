<tr wire:key="copy-{{ $copy->id }}">
    <td class="max-w-48 px-4 py-4 text-sm font-medium whitespace-nowrap">
        <h2 class="font-medium text-gray-800 dark:text-white truncate first-letter:uppercase">{{ $copy->edition?->book?->title }}</h2>
        <dl>
            <dt class="sr-only lg:hidden">Id</dt>
            <dd class="font-normal text-gray-600 dark:text-gray-400 truncate lg:hidden">
                @if ($copy->identifier)
                    {{ $copy->identifier }}
                @endif
            </dd>
            <dt class="sr-only">Autor</dt>
            <dd class="font-normal text-gray-600 dark:text-gray-400 truncate capitalize">
                @if ($copy->edition?->book?->pseudonyms->count())
                    {{ $copy->edition?->book?->pseudonyms->pluck('name')->join(', ') }}
                @else
                    <span class="italic text-xs">autor desconocido</span>
                @endif
            </dd>
            <dt class="sr-only">Editorial</dt>
            <dd class="font-normal text-gray-600 dark:text-gray-400 truncate capitalize">
                @if ($copy->edition?->editorial_id)
                    {{ $copy->edition?->editorial?->name }}
                @else
                    <span class="italic text-xs">editorial desconocida</span>
                @endif
            </dd>
        </dl>
    </td>

    <td class="hidden lg:table-cell px-4 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-400 capitalize">
        @if ($copy->identifier)
            {{ $copy->identifier }}
        @else
            <span class="italic text-xs">desconocido</span>
        @endif
    </td>

    <td class="max-w-0 sm:max-w-40 px-4 py-4 text-xs sm:text-sm whitespace-nowrap text-gray-700 dark:text-gray-400">
        <span class="text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 copia-{{ $copy->status }}">
            {{ App\Enums\CopyStatusEnum::options()[$copy->status] }}
        </span>
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

                    @can('update', $copy)
                        <a
                            href="{{ route('back.copies.edit', $copy) }}"
                            class="flex w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600
                                focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-600 transition duration-150 ease-in-out"
                            @click="show = false"
                            wire:navigate
                        >
                            <x-icons.edit class="w-5 h-5 me-2" />
                            Editar Copia
                        </a>
                    @endcan
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
