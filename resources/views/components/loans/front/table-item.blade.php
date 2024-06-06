<tr wire:key="loan-{{ $loan->id }}">
    <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
        <div class="font-medium text-gray-800 dark:text-white truncate first-letter:uppercase">
            @if ($loan->serial)
                {{ $loan->serial}}
            @else
                ---
            @endif
        </div>
    </td>

    <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
        <div class="font-medium text-gray-800 dark:text-white truncate first-letter:uppercase">{{ $loan->copy->edition?->book?->title }}</div>

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

    <td class="px-4 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-400">
        <p>
            <span x-tooltip.raw="Fecha de Inicio">
                {{ $loan->start_date->format('d/m/Y') }}
            </span>

            <x-icons.arrow class="inline-flex w-5 h-5" />

            <span x-tooltip.raw="Fecha Límite de Devolución">
                {{ $loan->limit_date->format('d/m/Y') }}
            </span>
        </p>
    </td>

    <td class="px-4 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-400 space-y-1">
        @if ($loan->devolution_date)
            <div>
                {{ $loan->devolution_date->format('d/m/Y') }}
            </div>
        @else
            <div>---</div>
        @endif

        @if ($loan->is_overdue)
            <div class="text-xs font-semibold rounded dark:text-yellow-300 border-yellow-300 text-yellow-600 tracking-wider">
                <x-icons.overdue-clock class="w-4 h-4 inline-flex" />
                ATRASADO
            </div>
        @endif
    </td>

    <td class="px-4 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-400 font-medium">
        @if ($loan->is_fineable && $loan->fine)
            <div>SI</div>
        @else
            <div>NO</div>
        @endif
    </td>

    <td class="px-4 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-400">
        <span class="text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 {{ str_replace(' ', '-', 'prestamo-' . $loan->status) }}">
            {{ App\Enums\LoanStatusEnum::options()[$loan->status] }}
        </span>
    </td>
</tr>
