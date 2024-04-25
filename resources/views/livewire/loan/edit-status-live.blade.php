<div class="my-6 px-4">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-xl font-medium text-gray-800 dark:text-white">Actualización de estado</h2>

        @if ($loan->status == App\Enums\LoanStatusEnum::EN_CURSO->value)
            <div class="px-6 py-4 bg-white dark:bg-gray-800 rounded-md border border-gray-200 dark:border-gray-700 mt-6">
                <x-validation-errors class="mb-4" />

                <form wire:submit.prevent="save">
                    <div class="md:grid md:grid-cols-3 md:gap-4">
                        <div>
                            <x-label value="Estado del Préstamo" />

                            <select
                                class="w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500
                                    dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                wire:model.change="loan_status"
                            >
                                <option value="">Seleccione el estado</option>
                                @foreach ($loan_statuses as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        @if ($is_copy_status_enabled)
                            <div class="mt-4 md:mt-0">
                                <x-label value="Estado de la Copia" />

                                <select
                                    class="w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500
                                        dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                    wire:model.change="copy_status"
                                >
                                    <option value="">Seleccione el estado</option>
                                    @foreach ($copy_statuses as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        @if ($loan->is_fineable && $loan->is_overdue && $is_handling_fine)
                            <div class="mt-4 md:mt-0">
                                <x-label value="Estado de la Multa" />

                                <select
                                    class="w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500
                                        dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                    wire:model.change="fine_status"
                                >
                                    <option value="">Seleccione el estado</option>
                                    @foreach ($fine_statuses as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </div>

                    <div class="mt-6">
                        <label class="inline-flex items-center cursor-pointer">
                            <input
                                class="sr-only peer"
                                type="checkbox"
                                wire:model.change="is_copy_status_enabled"
                            />

                            <div class="flex-shrink-0 relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>

                            <p class="ms-3 text-gray-700 dark:text-gray-300">
                                ¿Desea establecer el estado de la copia prestada de forma manual? si no lo hace la copia cambiará a disponible automáticamente.
                            </p>
                        </label>
                    </div>

                    @if ($loan->is_fineable && $loan->is_overdue)
                        <div class="mt-2">
                            <label class="inline-flex items-center cursor-pointer">
                                <input
                                    class="sr-only peer"
                                    type="checkbox"
                                    wire:model.change="is_handling_fine"
                                />

                                <div class="flex-shrink-0 relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>

                                <p class="ms-3 text-gray-700 dark:text-gray-300">
                                    ¿Desea gestionar la multa? si no lo hace quedará pendiente automáticamente.
                                </p>
                            </label>
                        </div>
                    @endif

                    <hr class="my-4 -mx-6 dark:border-gray-700">

                    <div class="flex justify-end gap-4 mt-4">
                        <x-primary-button
                            type="submit"
                        >
                            Guardar
                        </x-primary-button>
                    </div>
                </form>
            </div>
        @endif

        <div class="px-6 py-4 bg-white dark:bg-gray-800 rounded-md border border-gray-200 dark:border-gray-700 mt-6">
            <h3 class="text-sm md:text-lg text-gray-700 dark:text-white font-medium">
               Datos del Préstamo
            </h3>

            <hr class="my-4 -mx-6 dark:border-gray-700">

            <x-loans.user-data :user="$loan->user" />

            <x-loans.copy-data :copy="$loan->copy" />

            <div>
                <h4 class="text-sm md:text-base mb-2 text-gray-700 dark:text-gray-400">Información complementaria:</h4>

                <ul class="text-sm md:text-base ms-4 text-gray-700 dark:text-gray-400 dark:divide-gray-600">
                    @if ($loan->limit_date)
                        <li class="py-2 sm:flex sm:justify-between sm:gap-4">
                            <p class="font-medium sm:w-48">
                                Día Límite de Devolución
                            </p>

                            <p class="sm:flex-1 capitalize">
                                {{ Carbon\Carbon::parse($loan->limit_date)->format('d/m/Y') }}

                                @if ($loan->is_overdue)
                                    <span class="ms-2 align-middle text-xs font-semibold rounded dark:text-yellow-300 border-yellow-300 text-yellow-600 tracking-wider">
                                        <x-icons.overdue-clock class="w-4 h-4 inline-flex" />
                                        ATRASADO
                                    </span>
                                @endif
                            </p>
                        </li>
                    @endif

                    <li class="py-2 sm:flex sm:justify-between sm:gap-4">
                        <p class="font-medium sm:w-48">
                            ¿Es Multable?
                        </p>

                        <p class="sm:flex-1 capitalize">
                            {{ $loan->is_fineable ? 'SI' : 'NO' }}
                        </p>
                    </li>

                    @if ($loan->is_fineable)
                        <li class="py-2 sm:flex sm:justify-between sm:gap-4">
                            <p class="font-medium sm:w-48">
                                Monto de Multa (Diario)
                            </p>

                            <p class="sm:flex-1 capitalize">
                                $ {{ number_format($loan->fine_amount, 0, ',', '.') }}
                            </p>
                        </li>
                    @endif

                    @if ($loan->is_fineable && $loan->is_overdue && $loan->fine)
                        <li class="py-2 sm:flex sm:justify-between sm:gap-4">
                            <p class="font-medium sm:w-48">
                                Días Atrasados
                            </p>

                            <p class="sm:flex-1 capitalize">
                                {{ $loan->fine->days }}
                            </p>
                        </li>
                    @endif

                    @if ($loan->is_fineable && $loan->is_overdue && $loan->fine)
                        <li class="py-2 sm:flex sm:justify-between sm:gap-4">
                            <p class="font-medium sm:w-48">
                                Total de Multa
                            </p>

                            <p class="sm:flex-1 capitalize">
                                $ {{ number_format($loan->fine->total, 0, ',', '.') }}
                            </p>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>

@script
    <script type="text/javascript">
        Livewire.on('redirect', () => {
            Livewire.navigate('/back/loans');
        })
    </script>
@endscript
