<form wire:submit.prevent="save" @keydown.enter="event.preventDefault()">
    <div>
        <x-label value="Nombre" />

        <x-input
            class="w-full lg:w-3/4 mt-1"
            wire:model="form.firstname"
            x-ref="firstname"
            x-init="$focus.focus($el)"
        />

        <x-input-error for="form.firstname" />
    </div>

    <div class="mt-4">
        <x-label value="Apellido" />

        <x-input
            class="w-full lg:w-3/4 mt-1"
            wire:model="form.lastname"
        />

        <x-input-error for="form.lastname" />
    </div>

    <div class="mt-4">
        <x-label value="Pseudónimo" />

        <x-input
            class="w-full lg:w-3/4 mt-1"
            wire:model="form.pseudonym"
        />

        <x-input-error for="form.pseudonym" />
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
        <x-label value="Foto" />

        <input
            class="block w-full lg:w-3/4 px-3 py-1.5 mt-1 text-sm text-gray-600 border border-gray-300 dark:border-gray-700 dark:bg-gray-900
                rounded-md file:bg-gray-200 file:text-gray-700 file:text-sm file:px-4 file:py-1 file:border-none file:rounded-full
                dark:file:bg-gray-800 dark:file:text-gray-200 dark:text-gray-300 placeholder-gray-400/70 dark:placeholder-gray-500
                focus:outline-none focus:ring-1 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"
            wire:model="form.photo"
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

        @if ($form->photo)
            <div class="w-full lg:w-3/4">
                <img class="mx-auto mt-2" style="height: 300px;" src="{{ $form->photo->temporaryUrl() }}">
            </div>
        @endif

        <x-input-error for="form.photo" />
    </div>

    <div class="mt-4">
        <x-label value="Fecha de Nacimiento" />

        <x-input
            class="w-full lg:w-3/4 mt-1"
            x-init="
                const datebirthpicker = new CustomDatepicker($el, {
                    format: 'dd/mm/yyyy',
                    autohide: true,
                    language: 'es',
                    clearBtn: true,
                    todayBtn: true,
                    title: 'Fecha de Nacimiento',
                });

                datebirthpicker.setDate($wire.form.date_of_birth ?? null)

                $el.addEventListener('changeDate', (event) => $wire.form.date_of_birth = event.detail.date ? event.detail.date.toLocaleDateString('en-GB') : null);
            "
            x-mask="99/99/9999"
        />

        <x-input-error for="form.date_of_birth" />
    </div>

    <div class="relative mt-4">
        <x-label value="País de nacimiento" />

        <x-custom-select
            containerClass="w-full lg:w-3/4"
            :config="[
                'items' => 'form.countries',
                'value' => 'form.country_birth_id',
                'element' => 'country_list',
                'placeholder' => 'Selecciona un país',
                'empty' => 'No hay países disponibles.'
            ]"
            :listeners="[
                'update' => '
                    if (! $event.detail.value) return $wire.setCountryBirth(0);

                    $wire.setCountryBirth($event.detail.value);

                    $dispatch(\'states_loading\');
                ',
            ]"
        >
            <x-slot name="selectionContainer">
                <span class="mr-2 fi" :class=`fi-${selected.iso2.toLowerCase()}`></span>
            </x-slot>

            <x-slot name="optionContainer">
                <span class="mr-2 fi" :class=`fi-${item.iso2.toLowerCase()}`></span>
            </x-slot>
        </x-custom-select>

        <x-input-error for="form.country_birth_id" />
    </div>

    <div class="relative mt-4">
        <x-label value="Estado de nacimiento" />

        <x-custom-select
            containerClass="w-full lg:w-3/4"
            :config="[
                'items' => 'form.states',
                'value' => 'form.state_birth_id',
                'element' => 'state_list',
                'placeholder' => 'Selecciona un estado / departamento',
                'empty' => 'No hay estados disponibles.'
            ]"
            :listeners="[
                'update' => '
                    if (! $event.detail.value) return $wire.setStateBirth(0);

                    $wire.setStateBirth($event.detail.value);

                    $dispatch(\'cities_loading\');
                ',
                'states_loading.window' => 'currentFocus = \'\'; loading = true;',
                'states_loaded.window' => 'loading = false;'
            ]"
        />

        <x-input-error for="form.state_birth_id" />
    </div>

    <div class="relative mt-4">
        <x-label value="Ciudad de nacimiento" />

        <x-custom-select
            containerClass="w-full lg:w-3/4"
            :config="[
                'items' => 'form.cities',
                'value' => 'form.city_birth_id',
                'element' => 'city_list',
                'placeholder' => 'Selecciona una ciudad',
                'empty' => 'No hay ciudades disponibles.'
            ]"
            :listeners="[
                'update' => '
                    if (! $event.detail.value) return $wire.setCityBirth(0);

                    $wire.setCityBirth($event.detail.value);
                ',
                'cities_loading.window' => 'currentFocus = \'\'; loading = true;',
                'cities_loaded.window' => 'loading = false;'
            ]"
        />

        <x-input-error for="form.city_birth_id" />
    </div>

    <div class="mt-4">
        <x-label value="Fecha de Defunción" />

        <x-input
            class="w-full lg:w-3/4 mt-1"
            x-init="
                const datedeathpicker = new CustomDatepicker($el, {
                    format: 'dd/mm/yyyy',
                    autohide: true,
                    language: 'es',
                    clearBtn: true,
                    todayBtn: true,
                    title: 'Fecha de Defunción',
                });

                datedeathpicker.setDate($wire.form.date_of_death ?? null)

                $el.addEventListener('changeDate', (event) => $wire.form.date_of_death = event.detail.date ? event.detail.date.toLocaleDateString('en-GB') : null);
            "
            x-mask="99/99/9999"
        />

        <x-input-error for="form.date_of_death" />
    </div>

    <div class="mt-4">
        <x-label value="Biografía" />

        <div class="mt-1" wire:ignore>
            <div id="biography"></div>
        </div>

        <x-input-error for="form.biography" />
    </div>

    <hr class="my-4 -mx-6 dark:border-gray-700">

    <div class="flex justify-end gap-4">
        <a
            class="btn-sm flex items-center px-4 py-2 font-medium tracking-wide text-gray-600 capitalize
            transition-colors duration-300 transform bg-white rounded-lg hover:bg-gray-50 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80"
            href="{{ route('back.authors.index') }}"
            wire:navigate
        >cancelar</a>

        <x-primary-button
            class="btn-sm"
        >guardar</x-primary-button>
    </div>
</form>

@script
    <script>
        ClassicEditor
            .create(document.querySelector('#biography'), {
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

                editor.setData($wire.form.biography ?? '')

                editor.model.document.on('change:data', () => {
                    $wire.form.biography = editor.getData();
                })
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endscript
