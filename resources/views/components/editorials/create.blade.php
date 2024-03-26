<div x-data="{ isLoading: true }">
    <x-dropdown-floating width="w-96" position="bottom-end">
        <x-slot name="trigger">
            <button
                class="flex items-center justify-center px-5 py-2 text-sm tracking-wide text-white transition-colors duration-200 bg-blue-500 rounded-lg sm:w-auto
                    gap-x-2 hover:bg-blue-600 dark:hover:bg-blue-500 dark:bg-blue-600"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-plus w-5 h-5" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M9 12h6" /><path d="M12 9v6" /></svg>

                <span>Nuevo</span>
            </button>
        </x-slot>

        <x-slot name="content">
            <div
                @close-create-editorial.window="show = false"
                x-init="
                    $watch('show', value => { if (value) isLoading = true; $wire.showDialog(); } )
                    $wire.on('show-create-editorial', () => { isLoading = false; $nextTick(() => { $refs.name.focus() }); })
                "
            >
                <template x-if="isLoading">
                    <div class="flex justify-center items-center gap-2 my-4 dark:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-loader animate-spin w-6 h-6" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 6l0 -3" /><path d="M16.25 7.75l2.15 -2.15" /><path d="M18 12l3 0" /><path d="M16.25 16.25l2.15 2.15" /><path d="M12 18l0 3" /><path d="M7.75 16.25l-2.15 2.15" /><path d="M6 12l-3 0" /><path d="M7.75 7.75l-2.15 -2.15" /></svg>
                    </div>
                </template>

                <template x-if="! isLoading">
                    <x-editorials.form method="save" />
                </template>
            </div>
        </x-slot>
    </x-dropdown-floating>
</div>
