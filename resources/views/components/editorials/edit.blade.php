<div
    x-data="{ show: false, isLoading: false }"
    x-init="
        $wire.on('show-edit-editorial-{{ $editorial->id }}', () => { isLoading = false; $nextTick(() => { $refs.name.focus() }) })
        $wire.on('editorial-updated-{{ $editorial->id }}', () => { show = false; })
        $watch('show', value => { if (value) isLoading = true })
    "
    @set-edit-editorial-{{ $editorial->id }}.window="show = true"
>
    <div
        x-show="show"
        x-anchor.left-start.offset.5="$refs.editorial_{{ $editorial->id }}"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        @mousedown.outside="show = false"
        @keyup.escape="show = false"
        class="absolute w-96 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-md shadow-md"
    >
        <h3 class="inline-flex items-center text-gray-700 dark:text-white text-base font-medium px-6 py-4">
            <x-icons.edit class="w-5 h-5 me-2" />
            Editar Editorial
        </h3>

        <hr class="dark:border-gray-600">

        <template x-if="isLoading">
            <div class="flex justify-center items-center gap-2 my-4 dark:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-loader animate-spin w-6 h-6" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 6l0 -3" /><path d="M16.25 7.75l2.15 -2.15" /><path d="M18 12l3 0" /><path d="M16.25 16.25l2.15 2.15" /><path d="M12 18l0 3" /><path d="M7.75 16.25l-2.15 2.15" /><path d="M6 12l-3 0" /><path d="M7.75 7.75l-2.15 -2.15" /></svg>
            </div>
        </template>

        <template x-if="! isLoading">
            <x-editorials.form method="update" />
        </template>
    </div>
</div>
