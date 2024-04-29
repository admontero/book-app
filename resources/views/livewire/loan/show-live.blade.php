<div class="my-4 px-2 md:px-6">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-xl font-medium text-gray-800 dark:text-white">
            Gestión de Préstamo
        </h2>

        <div class="lg:flex lg:items-start lg:justify-between lg:gap-4 mt-4">
            <div class="lg:order-2 w-80 bg-white dark:bg-gray-800 divide-y sm:rounded-md overflow-hidden border border-gray-200 dark:border-gray-700 dark:divide-gray-700">
                <div class="flex justify-between px-4 py-4 sm:px-6 text-gray-700 dark:text-gray-200 font-medium">
                    <h3 class="text-sm lg:text-lg">
                        Acciones
                    </h3>
                </div>

                @can('updateStatus', $loan)
                    <div>
                        <x-dropdown-floating width="w-96" position="left-start">
                            <x-slot name="trigger">
                                <button
                                    class="w-full block px-4 py-2 text-left text-gray-700 dark:text-gray-200 border-l-2 focus:outline-none"
                                    :class="show ? 'border-blue-600' : 'border-transparent'"
                                >
                                    Cierre de Préstamo
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <form wire:submit.prevent="saveLoan">
                                    <div class="px-4 py-3">
                                        <div>
                                            <x-label class="font-medium" value="Estado del Préstamo" />

                                            <div class="flex flex-wrap gap-x-10 gap-y-2 mt-3 text-sm">
                                                @foreach ($loan_statuses as $value => $label)
                                                    <div wire:key="loan-status-radio-{{ $value }}">
                                                        <label class="inline-flex items-center cursor-pointer">
                                                            <input type="radio" wire:model.change="loan_status_form.loan_status" value="{{ $value }}" class="sr-only peer">

                                                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>

                                                            <p class="ms-3 text-gray-700 dark:text-gray-300">
                                                                {{ $label }}
                                                            </p>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <x-input-error for="loan_status_form.loan_status" />
                                        </div>

                                        <div class="mt-4">
                                            <x-label class="font-medium" value="Estado de la Copia" />

                                            <div class="flex flex-wrap gap-x-10 gap-y-2 mt-3 text-sm">
                                                @foreach ($copy_statuses as $value => $label)
                                                    <div wire:key="copy-status-radio-{{ $value }}">
                                                        <label class="inline-flex items-center cursor-pointer">
                                                            <input type="radio" wire:model.change="loan_status_form.copy_status" value="{{ $value }}" class="sr-only peer">

                                                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>

                                                            <p class="ms-3 text-gray-700 dark:text-gray-300">
                                                                {{ $label }}
                                                            </p>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <x-input-error for="loan_status_form.copy_status" />
                                        </div>
                                    </div>

                                    <div class="px-4 py-2 flex justify-end gap-4">
                                        <x-primary-button
                                            class="btn-sm"
                                            type="submit"
                                        >
                                            Guardar
                                        </x-primary-button>
                                    </div>
                                </form>
                            </x-slot>
                        </x-dropdown-floating>
                    </div>
                @else
                    <div>
                        <button
                            class="w-full block px-4 py-2 text-left text-gray-700 dark:text-gray-200 focus:outline-none disabled:opacity-75 disabled:cursor-not-allowed"
                            disabled="disabled"
                        >
                            Cierre de Préstamo
                        </button>
                    </div>
                @endcan

                @can('updateStatus', $loan->fine)
                    <div>
                        <x-dropdown-floating width="w-96" position="left-start">
                            <x-slot name="trigger">
                                <button
                                    class="w-full block px-4 py-2 text-left text-gray-700 dark:text-gray-200 border-l-2 focus:outline-none"
                                    :class="show ? 'border-blue-600' : 'border-transparent'"
                                >
                                    Cierre de Multa
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <form wire:submit.prevent="saveFine">
                                    <div class="px-4 py-3">
                                        <div>
                                            <x-label class="font-medium" value="Estado de la Multa" />

                                            <div class="flex flex-wrap gap-x-10 gap-y-2 mt-3 text-sm">
                                                @foreach ($fine_statuses as $value => $label)
                                                    <div wire:key="loan-status-radio-{{ $value }}">
                                                        <label class="inline-flex items-center cursor-pointer">
                                                            <input type="radio" wire:model.change="fine_status_form.fine_status" value="{{ $value }}" class="sr-only peer">

                                                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>

                                                            <p class="ms-3 text-gray-700 dark:text-gray-300">
                                                                {{ $label }}
                                                            </p>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <x-input-error for="fine_status_form.fine_status" />
                                        </div>
                                    </div>

                                    <div class="px-4 py-2 flex justify-end gap-4">
                                        <x-primary-button
                                            class="btn-sm"
                                            type="submit"
                                        >
                                            Guardar
                                        </x-primary-button>
                                    </div>
                                </form>
                            </x-slot>
                        </x-dropdown-floating>
                    </div>
                @else
                    <div>
                        <button
                            class="w-full block px-4 py-2 text-left text-gray-700 dark:text-gray-200 focus:outline-none disabled:opacity-75 disabled:cursor-not-allowed"
                            disabled="disabled"
                        >
                            Cierre de Multa
                        </button>
                    </div>
                @endcan
            </div>

            <div class="lg:order-1 lg:flex-1 mt-4 lg:mt-0">
                <div class="overflow-hidden bg-white dark:bg-gray-800 sm:rounded-md border border-gray-200 dark:border-gray-700">
                    <div x-data="{ expanded: true }">
                        <div class="flex justify-between px-4 py-4 sm:px-6 text-gray-700 dark:text-gray-200 font-medium">
                            <h3 class="text-sm lg:text-lg">
                                Datos Generales
                            </h3>

                            <button @click="expanded = ! expanded">
                                <x-icons.chevron class="w-5 h-5" ::class="expanded && 'rotate-90' " />
                            </button>
                        </div>

                        <div class="border-t border-gray-200 dark:border-gray-700" x-show="expanded" x-collapse>
                            <x-loans.data :loan="$loan" />
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700" x-data="{ expanded: true }">
                        <div class="flex justify-between px-4 py-4 sm:px-6 text-gray-700 dark:text-gray-200 font-medium">
                            <h3 class="text-sm lg:text-lg">
                                Datos del Lector
                            </h3>

                            <button @click="expanded = ! expanded">
                                <x-icons.chevron class="w-5 h-5" ::class="expanded && 'rotate-90' " />
                            </button>
                        </div>

                        <div class="border-t border-gray-200 dark:border-gray-700" x-show="expanded" x-collapse>
                            <x-loans.user-data :user="$loan->user" />
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700" x-data="{ expanded: true }">
                        <div class="flex justify-between px-4 py-4 sm:px-6 text-gray-700 dark:text-gray-200 font-medium">
                            <h3 class="text-sm lg:text-lg">
                                Datos de la Copia
                            </h3>

                            <button @click="expanded = ! expanded">
                                <x-icons.chevron class="w-5 h-5" ::class="expanded && 'rotate-90' " />
                            </button>
                        </div>

                        <div class="border-t border-gray-200 dark:border-gray-700" x-show="expanded" x-collapse>
                            <x-loans.copy-data :copy="$loan->copy" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
