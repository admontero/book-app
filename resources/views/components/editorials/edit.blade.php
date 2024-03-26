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
        x-anchor.left-start.offset.5="$refs.editorial{{ $editorial->id }}.firstElementChild"
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
            <svg class="icon icon-tabler icon-tabler-edit w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
            Editar Editorial
        </h3>

        <hr class="mb-4 dark:border-gray-600">

        <x-editorials.form method="update" />
    </div>
</div>
