<dl>
    <div class="px-4 py-3 bg-gray-50 dark:bg-gray-900 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
            ID
        </dt>

        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-3">
            {{ $loan->serial }}
        </dd>
    </div>

    <div class="px-4 py-3 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
            Estado
        </dt>

        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-3">
            <span class="text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 {{ str_replace(' ', '-', 'prestamo-' . $loan->status) }}">
                {{ App\Enums\LoanStatusEnum::options()[$loan->status] }}
            </span>
        </dd>
    </div>

    <div class="px-4 py-3 bg-gray-50 dark:bg-gray-900 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
            Fecha de Inicio
        </dt>

        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-3">
            @if ($loan->start_date)
                {{ $loan->start_date->format('d/m/Y') }}
            @else
                <span class="text-xs text-gray-400">N/A</span>
            @endif
        </dd>
    </div>

    <div class="px-4 py-3 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
            Fecha Límite
        </dt>

        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-3">
            @if ($loan->limit_date)
                {{ $loan->limit_date->format('d/m/Y') }}
            @else
                <span class="text-xs text-gray-400">N/A</span>
            @endif

            @if ($loan->is_overdue)
                <span class="align-top ms-2 text-xs font-semibold rounded dark:text-yellow-300 border-yellow-300 text-yellow-600 tracking-wider">
                    <x-icons.overdue-clock class="w-4 h-4 inline-flex" />
                    ATRASADO
                </span>
            @endif
        </dd>
    </div>

    <div class="px-4 py-3 bg-gray-50 dark:bg-gray-900 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
            Fecha de Devolución
        </dt>

        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-3">
            @if ($loan->devolution_date)
                {{ $loan->devolution_date->format('d/m/Y') }}
            @else
                <span class="text-xs text-gray-400">N/A</span>
            @endif
        </dd>
    </div>

    <div class="px-4 py-3 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
            ¿Es Multable?
        </dt>

        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-3">
            {{ $loan->is_fineable ? 'SI' : 'NO' }}
        </dd>
    </div>

    @if ($loan->is_fineable)
        <div class="px-4 py-3 bg-gray-50 dark:bg-gray-900 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Monto de Multa (Diario)
            </dt>

            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-3">
                $ {{ number_format($loan->fine_amount, 0, ',', '.') }}
            </dd>
        </div>
    @endif

    @if ($loan->isFined() && $loan->fine)
        <div class="px-4 py-3 bg-gray-50 dark:bg-gray-900 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Días Atrasados
            </dt>

            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-3">
                {{ $loan->fine->days }}
            </dd>
        </div>
    @endif

    @if ($loan->isFined() && $loan->fine)
        <div class="px-4 py-3 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Total de Multa
            </dt>

            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-3">
                $ {{ number_format($loan->fine->total, 0, ',', '.') }}

                <span class="ms-2 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 {{ str_replace(' ', '-', 'multa-' . $loan->fine->status) }}">
                    {{ App\Enums\FineStatusEnum::options()[$loan->fine->status] }}
                </span>
            </dd>
        </div>
    @endif
</dl>
