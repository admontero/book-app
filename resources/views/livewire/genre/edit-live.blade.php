<div>
    <div x-data="{ show: @entangle('isOpen') }">
        <div
            x-show="show"
            x-trap="show"
            x-anchor.left-start.offset.5="$refs.genre_{{ $id }}"
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
                Editar Género
            </h3>

            <hr class="dark:border-gray-600">

            <x-genres.form method="update" />
        </div>
    </div>
</div>
