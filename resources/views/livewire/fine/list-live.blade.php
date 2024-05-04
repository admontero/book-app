<section class="max-w-7xl px-4 mx-auto">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center gap-x-3">
                <h2 class="text-xl font-medium text-gray-800 dark:text-white">Multas</h2>

                <span class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full dark:bg-gray-800 dark:text-blue-400">{{ $this->finesCount }} multas</span>
            </div>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                Gestiona todas las multas generadas en el sistema, las cuales
                podrás filtrar y gestionar de acuerdo a su estado, además de
                detallar la información de su préstamo asociado.
            </p>
        </div>
    </div>

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
        <div class="flex flex-col mt-4" wire:key="fine-list">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-2 lg:-mx-4">
                <div class="inline-block min-w-full py-2 align-middle md:px-2 lg:px-4">
                    <div class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Usuario
                                    </th>

                                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Préstamo
                                    </th>

                                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Monto acumulable diario
                                    </th>

                                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Días de atraso
                                    </th>

                                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Total
                                    </th>

                                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Estado
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                                @foreach ($fines as $fine)
                                    <x-fines.table-item :$fine />
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @else
        <x-table-empty title="Ningún multa encontrado" wire:key="fine-list-empty">
            <x-alternative-button wire:click="$set('search', '')">Limpiar Buscador</x-alternative-button>
        </x-table-empty>
    @endif

    <div class="mt-4">
        {{ $fines->links('vendor.livewire.custom') }}
    </div>
</section>
