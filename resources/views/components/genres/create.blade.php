<div x-data="{ isClearValidationErrors: true }">
    <x-dropdown-floating width="w-96" position="bottom-end">
        <x-slot name="trigger">
            <button
                class="flex items-center justify-center px-5 py-2 text-sm tracking-wide text-white transition-colors duration-200 bg-blue-500 rounded-lg sm:w-auto
                    gap-x-2 hover:bg-blue-600 dark:hover:bg-blue-500 dark:bg-blue-600"
                @click="isClearValidationErrors = true"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-plus w-5 h-5" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M9 12h6" /><path d="M12 9v6" /></svg>

                <span>Nuevo</span>
            </button>
        </x-slot>

        <x-slot name="content">
            <form
                wire:submit="save"
                @close-create-genre.window="show = false"
                x-init="
                    $watch('show', value => { if (value) $wire.name = ''; $wire.resetValidation(); $nextTick(() => { $refs.name.focus() }); } )
                    $wire.on('validation-errors-cleared', () => { isClearValidationErrors = false; })
                "
            >
                <div class="px-4 py-5">
                    <x-label value="Nombre" />

                    <x-input
                        class="w-full mt-1"
                        wire:model="name"
                        x-ref="name"
                    />

                    @error('name')
                        <p class="text-xs text-red-600 dark:text-red-300 mt-1" x-show="! isClearValidationErrors">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="flex justify-end gap-4 px-4 py-2">
                    <x-default-button
                        class="btn-sm"
                        @click="show = false"
                    >cancelar</x-default-button>

                    <x-primary-button
                        class="btn-sm"
                    >guardar</x-primary-button>
                </div>
            </form>
        </x-slot>
    </x-dropdown-floating>
</div>
