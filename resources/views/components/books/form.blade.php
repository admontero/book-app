<form
    x-init="$nextTick(() => $refs.synopsis.dispatchEvent(new Event('autosize')))"
    @keydown.enter="event.preventDefault()"
    wire:submit.prevent="save"
>
    <div>
        <x-label value="Título" />

        <x-input
            class="w-full lg:w-3/4 mt-1"
            wire:model="form.title"
            x-ref="title"
            x-init="$focus.focus($el)"
        />

        <x-input-error for="form.title" />
    </div>

    <div class="mt-4">
        <x-label value="Año de Publicación" />

        <x-input
            class="w-full lg:w-3/4 mt-1"
            wire:model="form.publication_year"
        />

        <x-input-error for="form.publication_year" />
    </div>

    <div class="relative mt-4">
        <x-label value="Autor" />

        <x-custom-select
            containerClass="w-full lg:w-3/4"
            :config="[
                'items' => 'form.authors',
                'value' => 'form.author_id',
                'element' => 'author_list',
                'placeholder' => 'Selecciona un autor',
                'empty' => 'No hay autores disponibles.'
            ]"
            :listeners="[
                'update' => '
                    if (! $event.detail.value) return resetValue();

                    $wire.form.author_id = $event.detail.value
                ',
            ]"
        />

        <x-input-error for="form.author_id" />
    </div>

    <div class="relative mt-4">
        <x-label value="Géneros" />

        <x-custom-select
            containerClass="w-full lg:w-3/4"
            :config="[
                'items' => 'form.genres',
                'value' => 'form.genre_ids',
                'element' => 'genre_list',
                'isMultiple' => true,
                'isCreatable' => true,
                'placeholder' => 'Selecciona uno o varios géneros',
                'empty' => 'No hay géneros disponibles.'
            ]"
            :listeners="[
                'update' => '
                    if (! $event.detail.value) return resetValue();

                    $wire.setGenre($event.detail.value)
                ',
                'create' => '$wire.saveGenre(search)'
            ]"
        >
            <x-slot name="validationInput">
                <x-input-error for="genreForm.name" />
            </x-slot>
        </x-custom-select>

        <x-input-error for="form.genre_ids" />
    </div>

    <div class="mt-4">
        <x-label class="w-full lg:w-3/4 flex justify-between">
            <span>Sinopsis</span>

            <p class="text-xs text-gray-600 dark:text-gray-300 mt-1" :class="$wire.form.synopsis?.length > 800 ? 'text-red-600 dark:text-red-300' : ''">
                <span x-text="$wire.form.synopsis?.length ?? 0"></span>
                <span>/ 800</span>
            </p>
        </x-label>

        <textarea
            class="w-full lg:w-3/4 mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300
                focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md
                shadow-sm"
            rows="8"
            x-autosize
            x-ref="synopsis"
            wire:model="form.synopsis"
        ></textarea>

        <x-input-error for="form.synopsis" />
    </div>

    <hr class="my-4 -mx-6 dark:border-gray-700">

    <div class="flex justify-end gap-4">
        <a
            class="btn-sm flex items-center px-4 py-2 font-medium tracking-wide text-gray-600 capitalize
            transition-colors duration-300 transform bg-white rounded-lg hover:bg-gray-50 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80"
            href="{{ route('admin.books.index') }}"
            wire:navigate
        >cancelar</a>

        <x-primary-button
            class="btn-sm"
        >guardar</x-primary-button>
    </div>
</form>
