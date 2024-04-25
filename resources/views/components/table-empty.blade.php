<div class="flex items-center mt-6 bg-white text-center border rounded-lg h-96 dark:bg-gray-800 dark:border-gray-700">
    <div class="flex flex-col w-full max-w-sm px-4 mx-auto">
        <div class="p-3 mx-auto text-blue-500 bg-blue-100 rounded-full dark:bg-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search w-6 h-6" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
        </div>

        <h1 class="mt-3 text-lg text-gray-800 dark:text-white">{{ $title ?? 'Ningún registro encontrado' }}</h1>

        <p class="mt-2 text-gray-500 dark:text-gray-400">La búsqueda no halló coincidencias con nuestros registros. Inténtalo de nuevo por favor.</p>

        <div class="flex items-center justify-center mt-4 sm:mx-auto gap-x-3">
            <x-alternative-button
                class="w-1/2 px-5 py-2 text-sm text-gray-700 transition-colors duration-200 bg-white border rounded-lg sm:w-auto
                    dark:hover:bg-gray-800 dark:bg-gray-900 hover:bg-gray-100 dark:text-gray-200 dark:border-gray-700"
                wire:click="$set('search', '')"
            >
                Limpiar Buscador
            </x-alternative-button>
        </div>
    </div>
</div>
