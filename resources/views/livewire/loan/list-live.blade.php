<section class="max-w-7xl px-4 mx-auto">
    <div class="sm:flex sm:items-center sm:justify-between sm:gap-4">
        <div>
            <div class="flex items-center gap-x-3">
                <h2 class="text-xl font-medium text-gray-800 dark:text-white">Préstamos</h2>

                <span class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full dark:bg-gray-800 dark:text-blue-400">{{ $this->loansCount }} préstamos</span>
            </div>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                Gestiona todos los préstamos registrados en el sistema donde podrás
                completar o cancelar aquellos que estén en curso, además tendrás
                acceso a la asignación de nuevos préstamos si cuentas con dicho
                permiso.
            </p>
        </div>

        <div class="flex shrink-0 items-center justify-end mt-4">
            <a
                class="flex items-center justify-center px-5 py-2 text-sm tracking-wide text-white transition-colors duration-200 bg-blue-500 rounded-lg
                    sm:w-auto gap-x-2 hover:bg-blue-600 dark:hover:bg-blue-500 dark:bg-blue-600"
                href="{{ route('back.loans.create') }}"
                wire:navigate
            >
                <x-icons.add class="w-5 h-5" />

                <span>Nuevo</span>
            </a>
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

            @foreach (App\Enums\LoanStatusEnum::options() as $value => $label)
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
                    placeholder="Buscar préstamo..."
                    wire:model.live.debounce.500ms="search"
                />
            </div>
        </div>
    </div>

    @if ($loans->count())
        <div class="flex flex-col mt-4" wire:key="loan-list">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-2 lg:-mx-4">
                <div class="inline-block min-w-full py-2 align-middle md:px-2 lg:px-4">
                    <div class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        No.
                                    </th>

                                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Copia
                                    </th>

                                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Usuario
                                    </th>

                                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Fechas
                                    </th>

                                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Estado
                                    </th>

                                    <th scope="col" class="relative px-4 py-3.5">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                                @foreach ($loans as $loan)
                                    <x-loans.table-item :$loan />
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @else
        <x-table-empty title="Ningún préstamo encontrado" />
    @endif

    <div class="mt-4">
        {{ $loans->links('vendor.livewire.custom') }}
    </div>
</section>
