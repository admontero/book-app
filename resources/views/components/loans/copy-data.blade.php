<dl>
    @if ($copy->edition?->book)
        <div class="px-4 py-3 bg-gray-50 dark:bg-gray-900 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Título
            </dt>

            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-3 first-letter:uppercase">
                {{ $copy->edition?->book?->title }}
            </dd>
        </div>
    @endif

    @if ($copy->identifier)
        <div class="px-4 py-3 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                ID
            </dt>

            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-3">
                {{ $copy->identifier }}
            </dd>
        </div>
    @endif

    @if ($copy->edition?->editorial_id)
        <div class="px-4 py-3 bg-gray-50 dark:bg-gray-900 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Editorial
            </dt>

            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-3 capitalize">
                {{ $copy->edition?->editorial->name }}
            </dd>
        </div>
    @endif

    @if ($copy->edition?->isbn13)
        <div class="px-4 py-3 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                ISBN13
            </dt>

            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-3">
                {{ $copy->edition?->isbn13 }}
            </dd>
        </div>
    @endif

    @if ($copy->edition?->book?->pseudonyms->count())
        <div class="px-4 py-3 bg-gray-50 dark:bg-gray-900 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Autores
            </dt>

            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-3 capitalize">
                {{ $copy->edition?->book?->pseudonyms->pluck('name')->join(', ') }}
            </dd>
        </div>
    @else
        <div class="px-4 py-3 bg-gray-50 dark:bg-gray-900 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Autor
            </dt>

            <dd class="mt-1 text-sm italic text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-3 capitalize">
                Anónimo
            </dd>
        </div>
    @endif
</dl>
