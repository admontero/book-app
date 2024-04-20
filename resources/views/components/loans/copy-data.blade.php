<div>
    <h4 class="text-sm md:text-base mb-2 text-gray-700 dark:text-gray-400">Información del libro seleccionado:</h4>

    <ul class="text-sm md:text-base ms-4 text-gray-700 dark:text-gray-400 dark:divide-gray-600">
        @if ($this->copySelected?->edition?->book?->title)
            <li class="py-2 sm:flex sm:justify-between sm:gap-4">
                <p class="font-medium sm:w-48">
                    Título
                </p>

                <p class="sm:flex-1 first-letter:uppercase">
                    {{ $this->copySelected?->edition?->book?->title }}
                </p>
            </li>
        @endif

        @if ($this->copySelected?->identifier)
            <li class="py-2 sm:flex sm:justify-between sm:gap-4">
                <p class="font-medium sm:w-48">
                    ID
                </p>

                <p class="w-full sm:flex-1">
                    {{ $this->copySelected?->identifier }}
                </p>
            </li>
        @endif

        @if ($this->copySelected?->edition?->editorial_id)
            <li class="py-2 sm:flex sm:justify-between sm:gap-4">
                <p class="font-medium sm:w-48">
                    Editorial
                </p>

                <p class="w-full sm:flex-1 capitalize">
                    {{ $this->copySelected?->edition?->editorial->name }}
                </p>
            </li>
        @endif

        @if ($this->copySelected?->edition?->isbn13)
            <li class="py-2 sm:flex sm:justify-between sm:gap-4">
                <p class="font-medium sm:w-48">
                    ISBN13
                </p>

                <p class="w-full sm:flex-1 capitalize">
                    {{ $this->copySelected?->edition?->isbn13 }}
                </p>
            </li>
        @endif

        @if ($this->copySelected?->edition?->book?->author_id)
            <li class="py-2 sm:flex sm:justify-between sm:gap-4">
                <p class="font-medium sm:w-48">
                    Autor
                </p>

                <p class="w-full sm:flex-1 capitalize">
                    {{ $this->copySelected?->edition?->book?->author?->name }}
                </p>
            </li>
        @endif
    </ul>
</div>
