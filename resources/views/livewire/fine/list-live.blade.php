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
        <div class="inline-flex flex-col sm:flex-row w-full sm:w-auto divide-y sm:divide-y-0 overflow-hidden bg-white border sm:divide-x rounded-lg rtl:flex-row-reverse
            dark:border-gray-700 dark:divide-gray-700">
            <button
                class="px-5 py-2 text-xs font-medium text-gray-600 sm:text-sm dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-white
                    hover:bg-gray-100 {{ count($this->statusesArray) == 0 ? 'bg-gray-100 dark:bg-gray-900' : 'bg-white' }}"
                type="button"
                wire:click="$set('statuses', '')"
            >
                Ver todos
            </button>

            @foreach (App\Enums\FineStatusEnum::options() as $value => $label)
                <button
                    class="px-5 py-2 text-xs font-medium text-gray-600 dark:bg-gray-800 sm:text-sm dark:hover:bg-gray-700
                        dark:text-gray-300 hover:bg-gray-100 {{ in_array($value, $this->statusesArray) ? 'bg-gray-100 dark:bg-gray-900' : 'bg-white' }}"
                    type="button"
                    wire:click="setStatuses('{{ $value }}')"
                    wire:key="button-status-{{ $value }}"
                >
                    {{ $label }}
                </button>
            @endforeach
        </div>

        <div class="flex-1 flex justify-end items-center mt-4 md:mt-0">
            <div class="relative max-w-96 w-full">
                <span class="absolute top-2.5">
                    <x-icons.search class="w-5 h-5 mx-3 text-gray-400 dark:text-gray-500" />
                </span>

                <x-input
                    class="pl-11 w-full"
                    type="search"
                    placeholder="Buscar multa..."
                    wire:model.live.debounce.500ms="search"
                />
            </div>
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
        <x-table-empty title="Ninguna multa encontrada" />
    @endif

    <div class="mt-4">
        {{ $fines->links('vendor.livewire.custom') }}
    </div>
</section>
