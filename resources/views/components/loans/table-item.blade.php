<tr wire:key="loan-{{ $loan->id }}">
    <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
        <div class="text-gray-800 dark:text-white">{{ $loan->serial ?? '---' }}</div>
    </td>

    <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
        <h2 class="font-medium text-gray-800 dark:text-white truncate first-letter:uppercase">{{ $loan->copy->edition?->book?->title }}</h2>
        <dl>
            <dt class="sr-only">Id</dt>
            <dd class="font-normal text-gray-600 dark:text-gray-400 truncate">
                @if ($loan->copy->identifier)
                    {{ $loan->copy->identifier }}
                @endif
            </dd>
            <dt class="sr-only">Autor</dt>
            <dd class="font-normal text-gray-600 dark:text-gray-400 truncate capitalize">
                @if ($loan->copy->edition?->book?->pseudonyms->count())
                    {{ $loan->copy->edition?->book?->pseudonyms->pluck('name')->join(', ') }}
                @else
                    <span class="italic text-xs">autor desconocido</span>
                @endif
            </dd>
            <dt class="sr-only">Editorial</dt>
            <dd class="font-normal text-gray-600 dark:text-gray-400 truncate capitalize">
                @if ($loan->copy->edition?->editorial_id)
                    {{ $loan->copy->edition?->editorial?->name }}
                @else
                    <span class="italic text-xs">editorial desconocida</span>
                @endif
            </dd>
        </dl>
    </td>

    <td class="px-4 py-4 text-sm whitespace-nowrap">
        <p class="text-gray-800 dark:text-white">{{ $loan->user->name }}</p>
        <dl>
            <dt class="sr-only">Email</dt>
            <dd class="font-normal text-gray-600 dark:text-gray-400 truncate">
                {{ $loan->user->email }}
            </dd>
        </dl>
    </td>

    <td class="px-4 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-400 space-y-1 w-40 text-center">
        <p>
            <span x-tooltip.raw="Fecha de Inicio">
                {{ $loan->start_date->format('d/m/Y') }}
            </span>

            <x-icons.arrow class="inline-flex w-5 h-5" />

            <span x-tooltip.raw="Fecha Límite de Devolución">
                {{ $loan->limit_date->format('d/m/Y') }}
            </span>
        </p>

        @if ($loan->devolution_date)
            <div>
                <span class="font-semibold" x-tooltip.raw="Fecha de Devolución">
                    {{ $loan->devolution_date->format('d/m/Y') }}
                </span>
            </div>
        @endif

        @if ($loan->is_overdue)
            <div>
                <span class="text-xs font-semibold rounded dark:text-yellow-300 border-yellow-300 text-yellow-600 tracking-wider">
                    <x-icons.overdue-clock class="w-4 h-4 inline-flex" />
                    ATRASADO
                </span>
            </div>
        @endif
    </td>

    <td class="px-4 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-400">
        <span class="text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 {{ str_replace(' ', '-', 'prestamo-' . $loan->status) }}">
            {{ App\Enums\LoanStatusEnum::options()[$loan->status] }}
        </span>
    </td>

    <td class="px-4 py-4 text-sm whitespace-nowrap">
        <div class="flex justify-center gap-2 items-center">
            <div x-ref="loan_{{ $loan->id }}">
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

                    </x-slot>
                </x-dropdown-floating>
            </div>

            @can('view', $loan)
                <a
                    class="p-2 rounded-md bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-600 hover:text-gray-900
                    dark:text-white dark:hover:text-gray-300 border border-gray-200 dark:border-gray-600 shadow"
                    href="{{ route('back.loans.show', $loan) }}"
                    x-tooltip.raw="Ver"
                    wire:navigate
                >
                    <x-icons.show class="w-5 h-5" />
                </a>
            @endcan
        </div>
    </td>
</tr>
