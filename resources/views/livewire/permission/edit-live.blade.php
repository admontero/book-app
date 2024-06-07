<div>
    <div x-data="{ show: @entangle('isOpen') }">
        <div
            x-show="show"
            x-trap="show"
            x-anchor.left-start.offset.5="$refs.permission_{{ $id }}"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            @mousedown.outside="show = false"
            @keyup.escape="show = false"
            class="absolute max-w-96 w-full bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-md shadow-md"
        >
            <h3 class="inline-flex items-center text-gray-700 dark:text-white text-base font-medium px-6 py-4">
                <x-icons.edit class="w-5 h-5 me-2" />
                Editar Descripción
            </h3>

            <hr class="mb-4 dark:border-gray-600">

            <form wire:submit.prevent="save">
                <div class="px-4 py-2">
                    <x-label class="flex justify-between">
                        <span>Descripción</span>

                        <p class="text-xs text-gray-600 dark:text-gray-300 mt-1" :class="$wire.form.description?.length > 180 ? 'text-red-600 dark:text-red-300' : ''">
                            <span x-text="$wire.form.description?.length ?? 0"></span>
                            <span>/ 180</span>
                        </p>
                    </x-label>

                    <textarea
                        class="w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500
                            dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        placeholder="Escribe una descripción..."
                        rows="5"
                        x-trap="show"
                        x-autosize
                        wire:model="form.description"
                        wire:ignore
                    ></textarea>

                    <x-input-error for="form.description" />

                    <div class="flex justify-end gap-4 mt-4">
                        <x-default-button
                            class="btn-sm"
                            @click="show = false"
                        >cancelar</x-default-button>

                        <x-primary-button
                            class="btn-sm"
                            type="submit"
                        >Guardar</x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
