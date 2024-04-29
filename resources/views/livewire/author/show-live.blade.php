<div class="my-4 px-2 md:px-6">
    <div class="max-w-7xl mx-auto lg:flex gap-4">
        <div class="lg:w-4/12 2xl:w-3/12">
            <x-authors.card :$author />
        </div>

        <div class="lg:w-8/12 2xl:w-9/12">
            <div class="bg-white dark:bg-gray-800 overflow-hidden rounded-md border border-gray-200 dark:border-gray-700 mt-4 lg:mt-0">
                <dl>
                    <div class="px-4 py-3 bg-gray-50 dark:bg-gray-900 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Fecha de Nacimiento
                        </dt>

                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-3">
                            @if ($author->date_of_birth)
                                {{ $author->date_of_birth->format('d/m/Y') }}
                            @else
                                <span class="text-xs text-gray-400">N/A</span>
                            @endif
                        </dd>
                    </div>

                    <div class="px-4 py-3 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Lugar de Nacimiento
                        </dt>

                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-3">
                            @if ($author->country_birth_id)
                                {{ $author->place_of_birth }}
                            @else
                                <span class="text-xs text-gray-400">N/A</span>
                            @endif
                        </dd>
                    </div>

                    <div class="px-4 py-3 bg-gray-50 dark:bg-gray-900 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Fecha de Defunción
                        </dt>

                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-3">
                            @if ($author->date_of_death)
                                {{ $author->date_of_death->format('d/m/Y') }}
                            @else
                                <span class="text-xs text-gray-400">N/A</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>

            @if ($author->biography)
                <div class="px-4 py-3 bg-white dark:bg-gray-800 overflow-hidden rounded-md border border-gray-200 dark:border-gray-700 mt-4">
                    {!! $author->biography !!}
                </div>
            @endif
        </div>
    </div>
</div>
