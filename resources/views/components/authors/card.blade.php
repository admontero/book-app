<div class="bg-white dark:bg-gray-800 rounded-md border border-gray-200 dark:border-gray-700">
    <div class="p-4 space-y-4">
        <img class="w-52 h-52 mx-auto rounded-full object-cover" src="{{ $author->photo_url }}" alt="foto de {{ $author->full_name }}" />

        <h2 class="text-lg text-center capitalize dark:text-gray-200">{{ $author->full_name }}</h2>
    </div>

    <hr class="dark:border-gray-700">

    <ul class="text-sm text-gray-700 dark:text-gray-200">
        <li>
            <a
                class="px-4 py-3 w-full block text-start text-sm leading-5 focus:outline-none text-gray-700 dark:text-gray-300"
                href="{{ route('back.authors.edit', $author) }}"
                wire:navigate
            >
                <x-icons.edit class="inline-flex w-5 h-5 me-2" />
                Editar Autor
            </a>
        </li>
    </ul>
</div>
