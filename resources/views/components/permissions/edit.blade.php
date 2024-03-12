<div
    x-data="{ show: false, isLoading: false }"
    x-init="
        $wire.on('show-edit-description-{{ $permission->id }}', () => { isLoading = false; $nextTick(() => { $refs.description.focus() }) })
        $wire.on('close-edit-description-{{ $permission->id }}', () => { show = false; })
        $watch('show', value => { if (value) isLoading = true })
    "
    @set-edit-description-{{ $permission->id }}.window="show = true"
>
    <div
        x-show="show"
        x-anchor.left-start.offset.5="$refs.permission{{ $permission->id }}.firstElementChild"
        x-ref="menu"
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
        <form wire:submit="saveDescription">
            <h3 class="inline-flex items-center text-gray-700 dark:text-white text-base font-medium px-6 py-4">
                <svg class="icon icon-tabler icon-tabler-edit w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                Editar Descripción
            </h3>

            <hr class="mb-4 dark:border-gray-600">

            <template x-if="! isLoading">
                <div class="px-4 py-2">
                    <x-label class="flex justify-between">
                        <span>Descripción</span>

                        <p class="text-xs text-gray-600 dark:text-gray-300 mt-1" :class="$wire.description.length > 180 ? 'text-red-600 dark:text-red-300' : ''">
                            <span x-text="$wire.description.length"></span>
                            <span>/ 180</span>
                        </p>
                    </x-label>

                    <textarea
                        class="w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500
                            dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        rows="5"
                        wire:model="description"
                        x-ref="description"
                        placeholder="Escribe una descripción..."
                    ></textarea>

                    @error('description')
                        <p class="text-xs text-red-600 dark:text-red-300 mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                    <div class="flex justify-end gap-4 mt-4">
                        <x-default-button
                            class="btn-sm"
                            @click="show = false"
                        >cancelar</x-default-button>

                        <x-primary-button
                            class="btn-sm"
                        >guardar</x-primary-button>
                    </div>
                </div>
            </template>

            <template x-if="isLoading">
                <div class="flex justify-center items-center gap-2 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-loader animate-spin dark:text-white" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 6l0 -3" /><path d="M16.25 7.75l2.15 -2.15" /><path d="M18 12l3 0" /><path d="M16.25 16.25l2.15 2.15" /><path d="M12 18l0 3" /><path d="M7.75 16.25l-2.15 2.15" /><path d="M6 12l-3 0" /><path d="M7.75 7.75l-2.15 -2.15" /></svg>
                </div>
            </template>
        </form>
    </div>
</div>
