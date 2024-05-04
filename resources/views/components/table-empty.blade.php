@props(['title' => null, 'body' => null])

<div {{ $attributes->merge(['class' => 'flex items-center mt-6 bg-white text-center border rounded-lg h-96 dark:bg-gray-800 dark:border-gray-700']) }}>
    <div class="flex flex-col w-full max-w-sm px-4 mx-auto">
        <div class="p-3 mx-auto text-blue-500 bg-blue-100 rounded-full dark:bg-gray-800">
            <x-icons.search class="w-6 h-6" />
        </div>

        <h1 class="mt-3 text-lg text-gray-800 dark:text-white">{{ $title ?? 'Ningún registro encontrado' }}</h1>

        <p class="mt-2 text-gray-500 dark:text-gray-400">{{ $body ?? 'La búsqueda no halló coincidencias con nuestros registros. Inténtalo de nuevo por favor.' }}</p>

        <div class="flex items-center justify-center mt-4 sm:mx-auto gap-x-3">
            {{ $slot }}
        </div>
    </div>
</div>
