<div class="max-w-7xl mx-auto lg:flex gap-4 px-4">
    <div class="lg:w-4/12 2xl:w-3/12">
        <x-authors.card :$author />
    </div>

    <div class="lg:w-8/12 2xl:w-9/12">
        <div class="px-6 py-4 bg-white dark:bg-gray-800 rounded-md border border-gray-200 dark:border-gray-700 mt-4 lg:mt-0">
            <ul class="text-sm text-gray-700 dark:text-gray-200 space-y-2">
                <li>
                    <span class="font-semibold">Nacimiento: </span>

                    @if ($this->date_of_birth)
                        {{ $this->date_of_birth }}
                    @else
                        <span class="italic">Desconocido</span>
                    @endif

                    @if ($author->country_birth_id)
                        <span>en {{ $author->place_of_birth }}</span>
                    @endif
                </li>

                <li>
                    <span class="font-semibold">Fallecimiento: </span>

                    @if ($this->date_of_death)
                        {{ $this->date_of_death }}
                    @else
                        <span class="italic">Desconocido</span>
                    @endif
                </li>

                <li>
                    <p class="font-semibold">Biografía. </p>

                    {!! $author->biography !!}
                </li>
            </ul>
        </div>
    </div>
</div>
