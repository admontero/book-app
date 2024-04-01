<div class="bg-white dark:bg-gray-800 rounded-md border border-gray-200 dark:border-gray-700 px-4 py-2">
    <img class="w-52 h-52 mx-auto rounded-full object-cover" src="{{ $author->photo_url }}" alt="foto de {{ $author->name }}" />

    <hr class="my-2 -mx-4 border-transparent">

    <h2 class="text-lg text-center capitalize dark:text-gray-200">{{ $author->name }}</h2>

    <hr class="my-4 -mx-4 dark:border-gray-700">

    <ul class="text-sm text-gray-700 dark:text-gray-200 space-y-2">
        <li>
            <a
                class="inline-flex items-center w-full text-start text-sm leading-5 focus:outline-none text-gray-700 dark:text-gray-300"
                href="{{ route('back.authors.edit', $author) }}"
                wire:navigate
            >
            <svg class="icon icon-tabler icon-tabler-edit w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                Editar Autor
            </a>
        </li>
    </ul>
</div>
