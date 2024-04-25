<div>
    <div class="relative">
        <x-label value="Libro" />

        <x-custom-select
            containerClass="w-full lg:w-3/4"
            :config="[
                'items' => 'form.books',
                'value' => 'form.book_id',
                'element' => 'book_list',
                'placeholder' => 'Selecciona el libro',
                'empty' => 'No hay libros disponibles.'
            ]"
            :listeners="[
                'update' => '
                    if (! $event.detail.value) return resetValue();

                    $wire.form.book_id = $event.detail.value
                ',
            ]"
        />

        <x-input-error for="form.book_id" />
    </div>

    <div class="relative mt-4">
        <x-label value="Editorial" />

        <x-custom-select
            containerClass="w-full lg:w-3/4"
            :config="[
                'items' => 'form.editorials',
                'value' => 'form.editorial_id',
                'element' => 'editorial_list',
                'placeholder' => 'Selecciona la editorial',
                'empty' => 'No hay editoriales disponibles.'
            ]"
            :listeners="[
                'update' => '
                    if (! $event.detail.value) return resetValue();

                    $wire.form.editorial_id = $event.detail.value
                ',
            ]"
        />

        <x-input-error for="form.editorial_id" />
    </div>

    <div
        class="mt-4"
        x-data="{ uploading: false, progress: 0 }"
        x-on:livewire-upload-start="uploading = true"
        x-on:livewire-upload-finish="uploading = false"
        x-on:livewire-upload-cancel="uploading = false"
        x-on:livewire-upload-error="uploading = false"
        x-on:livewire-upload-progress="progress = $event.detail.progress"
    >
        <x-label value="Portada" />

        <input
            class="block w-full lg:w-3/4 px-3 py-1.5 mt-1 text-sm text-gray-600 border border-gray-300 dark:border-gray-700 dark:bg-gray-900
                rounded-md file:bg-gray-200 file:text-gray-700 file:text-sm file:px-4 file:py-1 file:border-none file:rounded-full
                dark:file:bg-gray-800 dark:file:text-gray-200 dark:text-gray-300 placeholder-gray-400/70 dark:placeholder-gray-500
                focus:outline-none focus:ring-1 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"
            wire:model="form.cover"
            type="file"
        />

        <div class="mt-2" x-show="uploading">
            <progress
                class="h-2 [&::-webkit-progress-bar]:rounded-lg [&::-webkit-progress-value]:rounded-lg [&::-webkit-progress-bar]:bg-slate-300
                    [&::-webkit-progress-value]:bg-green-400 [&::-moz-progress-bar]:bg-green-400"
                max="100"
                x-bind:value="progress"
            ></progress>
        </div>

        @if ($form->cover)
            <div class="w-full lg:w-3/4">
                <img class="mx-auto mt-2" style="height: 300px;" src="{{ $form->cover->temporaryUrl() }}">
            </div>
        @endif

        <x-input-error for="form.cover" />
    </div>

    <div class="mt-4">
        <x-label value="ISBN13" />

        <x-input
            class="w-full lg:w-3/4 mt-1"
            wire:model="form.isbn13"
            x-mask="9999999999999"
        />

        <x-input-error for="form.isbn13" />
    </div>

    <div class="mt-4">
        <x-label value="Año" />

        <x-input
            class="w-full lg:w-3/4 mt-1"
            wire:model="form.year"
            x-mask="9999"
        />

        <x-input-error for="form.year" />
    </div>

    <div class="mt-4">
        <x-label value="Páginas" />

        <x-input
            class="w-full lg:w-3/4 mt-1"
            wire:model="form.pages"
        />

        <x-input-error for="form.pages" />
    </div>

    <hr class="my-4 -mx-6 dark:border-gray-700">

    <div class="flex justify-end gap-4">
        <a
            class="btn-sm flex items-center px-4 py-2 font-medium tracking-wide text-gray-600 capitalize
            transition-colors duration-300 transform bg-white rounded-lg hover:bg-gray-50 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80"
            href="{{ route('back.editions.index') }}"
            wire:navigate
        >cancelar</a>

        <x-primary-button
            class="btn-sm"
            type="submit"
        >Guardar</x-primary-button>
    </div>
</div>
