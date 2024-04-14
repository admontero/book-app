<div>
    <div class="max-w-7xl mx-auto py-4">
        <div class="md:flex md:justify-between md:gap-4 px-2 md:px-6">
            <div class="hidden md:block w-96"></div>
            <div class="flex-1">
                <h2 class="text-2xl capitalize font-medium dark:text-white">{{ $edition->book->title }}</h2>
            </div>
        </div>

        <div class="md:flex md:justify-between md:gap-4 mt-4">
            <div class="w-full md:w-96">
                <img src="{{ asset($edition->cover_url) }}" class="h-[300px] mx-auto object-cover object-center block rounded">
            </div>

            <div class="w-full md:flex-1 space-y-2 px-2 md:px-6 mt-4 md:mt-0">
                <ul class="divide-y-2 text-gray-700 dark:text-gray-400 dark:divide-gray-600">
                    @if ($edition->editorial_id)
                        <li class="py-2 flex justify-between gap-4">
                            <span class="font-medium w-36">
                                Editorial
                            </span>
                            <span class="flex-1 capitalize">
                                {{ $edition->editorial->name }}
                            </span>
                        </li>
                    @endif

                    @if ($edition->year)
                        <li class="py-2 flex justify-between gap-4">
                            <span class="font-medium w-36">
                                Publicación
                            </span>
                            <span class="flex-1 capitalize">
                                {{ $edition->year }}
                            </span>
                        </li>
                    @endif

                    @if ($edition->isbn13)
                        <li class="py-2 flex justify-between gap-4">
                            <span class="font-medium w-36">
                                ISBN13
                            </span>
                            <span class="flex-1 capitalize">
                                {{ $edition->isbn13 }}
                            </span>
                        </li>
                    @endif

                    @if ($edition->pages)
                        <li class="py-2 flex justify-between gap-4">
                            <span class="font-medium w-36">
                                Páginas
                            </span>
                            <span class="flex-1 capitalize">
                                {{ $edition->pages }}
                            </span>
                        </li>
                    @endif

                    <li class="py-2 flex justify-between gap-4">
                        <span class="font-medium w-36">
                            Géneros
                        </span>
                        <span class="flex-1 capitalize">
                            {{ implode(', ', $edition->book?->genres?->pluck('name')->toArray()) }}
                        </span>
                    </li>
                </ul>

                @if ($edition->book->synopsis)
                    <div>
                        <div class="mt-4 space-y-2">
                            <h4 class="text-xl font-medium text-gray-800 dark:text-gray-200">Sinopsis</h4>

                            <p class="text-gray-700 dark:text-gray-400">
                                {{ $edition->book->synopsis }}
                            </p>
                        </div>
                    </div>
                @endif

                @if ($edition->book->author_id)
                    <div x-data="{ expanded: false }">
                        <div class="mt-10" x-show="expanded" x-collapse.min.137px>
                            <img
                                class="float-left mr-4 w-32 h-32 rounded-lg object-cover"
                                src="{{ $edition->book->author->photo_url }}"
                                alt="foto de {{ $edition->book->author->name }}"
                            />

                            <div class="space-y-2">
                                <h5 class="text-lg font-medium text-gray-800 dark:text-gray-200 capitalize">
                                    {{ $edition->book->author->name }}

                                    @if ($edition->book->author->biography)
                                        <button
                                            class="underline underline-offset-2 ms-2 text-sm font-medium text-blue-600 hover:underline dark:text-blue-500"
                                            @click="expanded = ! expanded"
                                        >
                                            <span><span x-text="expanded ? 'Ocultar' : 'Mostrar'"></span> biografía completa</span>
                                        </button>
                                    @endif
                                </h5>

                                <p>
                                    {!! $edition->book->author->biography !!}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
