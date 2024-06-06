<div>
    <div class="px-4 py-3">
        <div>
            <x-label value="Nombre" />

            <x-input
                class="w-full lg:w-3/4 mt-1"
                wire:model="form.name"
                x-ref="name"
                x-init="$focus.focus($el)"
            />

            <x-input-error for="form.name" />
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

        <div class="mt-4">
            <x-label value="Descripción" />

            <div class="mt-1" wire:ignore>
                <div id="description"></div>
            </div>

            <x-input-error for="form.description" />
        </div>
    </div>

    <hr class="dark:border-gray-700">

    <div class="p-4 flex justify-end gap-4">
        <a
            class="btn-sm flex items-center px-4 py-2 font-medium tracking-wide text-gray-600 capitalize
            transition-colors duration-300 transform bg-white rounded-lg hover:bg-gray-50 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80"
            href="{{ route('back.pseudonyms.index') }}"
            wire:navigate
        >cancelar</a>

        <x-primary-button
            class="btn-sm"
            type="submit"
        >Guardar</x-primary-button>
    </div>
</div>

@script
    <script>
        ClassicEditor
            .create(document.querySelector('#description'), {
                toolbar: {
                    items: [
                        'undo', 'redo',
                        '|', 'heading',
                        '|', 'bold', 'italic',
                        '|', 'link', 'blockQuote',
                        '|', 'bulletedList', 'numberedList', 'outdent', 'indent'
                    ],
                    shouldNotGroupWhenFull: true
                },
            })
            .then(editor => {

                editor.setData($wire.form.description ?? '')

                editor.model.document.on('change:data', () => {
                    $wire.form.description = editor.getData();
                })
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endscript
