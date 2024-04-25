<section class="max-w-7xl px-4 mx-auto">
    <h2 class="text-xl font-medium text-gray-800 dark:text-white">Multas</h2>

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
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search w-5 h-5 mx-3 text-gray-400 dark:text-gray-600" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                </span>

                <x-input
                    class="pl-11 w-full"
                    type="search"
                    placeholder="Buscar préstamo..."
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
                                        # Préstamo
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
                                    <x-fines.front.table-item :$fine />
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
        {{ $fines->links() }}
    </div>
</section>
