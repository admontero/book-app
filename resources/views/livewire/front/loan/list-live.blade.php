<section class="max-w-7xl px-4 mx-auto">
    <h2 class="text-xl font-medium text-gray-800 dark:text-white">Préstamos</h2>

    <div class="mt-6 md:flex md:flex-wrap md:gap-4 md:items-center md:justify-between">
        <x-button-group>
            <x-button-group-item
                :selected="! count($this->statusesArray)"
                wire:click="$set('statuses', '')"
            >
                Ver todos
            </x-button-group-item>

            @foreach (App\Enums\LoanStatusEnum::options() as $value => $label)
                <x-button-group-item
                    :selected="in_array($value, $this->statusesArray)"
                    wire:click="setStatuses('{{ $value }}')"
                    wire:key="button-status-{{ $value }}"
                >
                    {{ $label }}
                </x-button-group-item>
            @endforeach
        </x-button-group>

        <div class="flex-1 flex justify-end items-center mt-4 md:mt-0">
            <x-search-input
                class="max-w-96 w-full"
                placeholder="Buscar préstamo..."
                wire:model.live.debounce.500ms="search"
            />
        </div>
    </div>

    @if ($loans->count())
        <x-table-container class="mt-4" wire:key="loan-list">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <x-table-header-cell value="No." />

                    <x-table-header-cell value="Copia" />

                    <x-table-header-cell value="Lapso" />

                    <x-table-header-cell value="Fecha de Devolución" />

                    <x-table-header-cell value="¿Con multa?" />

                    <x-table-header-cell value="Estado" />
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                @foreach ($loans as $loan)
                    <x-loans.front.table-item :$loan />
                @endforeach
            </tbody>
        </x-table-container>
    @else
        <x-table-empty title="Ningún préstamo encontrado" wire:key="loan-list-empty">
            <x-alternative-button wire:click="$set('search', '')">Limpiar Buscador</x-alternative-button>
        </x-table-empty>
    @endif

    <div class="mt-4">
        {{ $loans->links() }}
    </div>
</section>
