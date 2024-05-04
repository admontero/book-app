<section class="max-w-7xl px-4 mx-auto">
    <h2 class="text-xl font-medium text-gray-800 dark:text-white">Multas</h2>

    <div class="mt-6 md:flex md:flex-wrap md:gap-4 md:items-center md:justify-between">
        <x-button-group>
            <x-button-group-item
                :selected="! count($this->statusesArray)"
                wire:click="$set('statuses', '')"
            >
                Ver todos
            </x-button-group-item>

            @foreach (App\Enums\FineStatusEnum::options() as $value => $label)
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
                placeholder="Buscar multa..."
                wire:model.live.debounce.500ms="search"
            />
        </div>
    </div>

    @if ($fines->count())
        <x-table-container class="mt-4" wire:key="fine-list">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <x-table-header-cell value="Préstamo" />

                    <x-table-header-cell value="Monto acumulable diario" />

                    <x-table-header-cell value="Días de atraso" />

                    <x-table-header-cell value="Total" />

                    <x-table-header-cell value="Estado" />
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                @foreach ($fines as $fine)
                    <x-fines.front.table-item :$fine />
                @endforeach
            </tbody>
        </x-table-container>
    @else
        <x-table-empty title="Ningún multa encontrado" wire:key="fine-list-empty">
            <x-alternative-button wire:click="$set('search', '')">Limpiar Buscador</x-alternative-button>
        </x-table-empty>
    @endif

    <div class="mt-4">
        {{ $fines->links() }}
    </div>
</section>
