<div class="max-w-7xl mx-auto lg:flex gap-4 px-4">
    <div class="lg:w-4/12 2xl:w-3/12">

    </div>

    <div class="lg:w-8/12 2xl:w-9/12">
        <div class="px-6 py-4 bg-white dark:bg-gray-800 rounded-md border border-gray-200 dark:border-gray-700 mt-4 lg:mt-0">
            <form wire:submit.prevent="save" @keydown.enter="event.preventDefault()">
                <h2 class="inline-flex items-center text-gray-700 dark:text-white font-medium text-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-plus w-5 h-5 mr-2" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M9 12h6" /><path d="M12 9v6" /></svg>
                    Nuevo Autor
                </h2>

                <hr class="my-4 -mx-6 dark:border-gray-700">

                <div>
                    <x-label value="Nombre" />

                    <x-input
                        class="w-full lg:w-3/4 mt-1"
                        wire:model="name"
                        x-ref="name"
                        x-init="$focus.focus($el)"
                    />

                    @error('name')
                        <p class="text-xs text-red-600 dark:text-red-300 mt-1">
                            {{ $message }}
                        </p>
                    @enderror
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
                        wire:model="photo"
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

                    @if ($photo)
                        <div class="w-full lg:w-3/4">
                            <img class="mx-auto mt-2" style="height: 300px;" src="{{ $photo->temporaryUrl() }}">
                        </div>
                    @endif

                    @error('photo')
                        <p class="text-xs text-red-600 dark:text-red-300 mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mt-4">
                    <x-label value="Fecha de Nacimiento" />

                    <x-input
                        class="w-full lg:w-3/4 mt-1"
                        x-init="
                            new CustomDatepicker($el, {
                                format: 'dd/mm/yyyy',
                                autohide: true,
                                language: 'es',
                                clearBtn: true,
                                todayBtn: true,
                                title: 'Fecha de Nacimiento',
                            });

                            $el.addEventListener('changeDate', (event) => $wire.date_of_birth = event.detail.date ? event.detail.date.toLocaleDateString('en-GB') : null);
                        "
                        x-mask="99/99/9999"
                    />

                    @error('date_of_birth')
                        <p class="text-xs text-red-600 dark:text-red-300 mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div
                    class="relative mt-4"
                    x-data="
                        initCustomSelect({
                            items: {{ Illuminate\Support\Js::from($countries) }}
                                .sort((a, b) => a.name.toLowerCase().localeCompare(b.name.toLowerCase())),
                            value: @entangle('country_birth_id'),
                            element: $refs.country_list,
                            setMethod: $wire.setCountryBirthId,
                            eventLoading: 'states',
                        })
                    "
                    x-init="$watch('search', value => currentElement = '')"
                >
                    <x-label value="País de nacimiento" />

                    <div
                        class="w-full lg:w-3/4"
                        @mousedown.outside="show = false"
                        @keyup.esc="show = false"
                    >
                        <button
                            class="w-full mt-1 py-2 px-3 border text-left border-gray-300 dark:border-gray-700 dark:bg-gray-900
                                dark:text-gray-300 focus:ring-1 focus:outline-none focus:border-indigo-500 dark:focus:border-indigo-600
                                focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            type="button"
                            @click="show = ! show"
                            @keydown.tab="show = false"
                            @keyup.enter="show = true"
                            @keyup.up="show = true"
                            @keyup.down="show = true"
                        >
                            <div class="flex justify-between items-center">
                                <template x-if="! value">
                                    <span class="text-gray-400">Selecciona un país</span>
                                </template>
                                <template x-if="value">
                                    <div>
                                        <span class="mr-2 fi" :class=`fi-${selectedItem?.iso2.toLowerCase()}`></span>
                                        <span x-text="selectedItem?.name"></span>
                                    </div>
                                </template>

                                <div class="flex items-center gap-x-4">
                                    <template x-if="value">
                                        <span
                                            class="p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200 ease-in-out"
                                            @click.stop="$wire.setCountryBirthId(0); $focus.focus($refs.search); $refs.country_list.scrollTo({ top: 0 });"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x w-3 h-3" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
                                        </span>
                                    </template>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-down w-5 h-5 text-gray-500" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9l6 6l6 -6" /></svg>
                                </div>
                            </div>
                        </button>

                        <div
                            class="absolute py-1 start-0 w-96 bg-white dark:bg-gray-700 rounded-md shadow-md border border-gray-200
                                dark:border-gray-600 z-50 overflow-x-hidden mt-2"
                            x-show="show"
                            x-trap.inert="show"
                            x-bind="dialog"
                        >
                            <div class="px-3 my-3">
                                <x-input
                                    class="w-full"
                                    type="search"
                                    x-ref="search"
                                    x-model="search"
                                    x-bind="input"
                                />
                            </div>

                            <div class="max-h-52 overflow-y-auto" x-ref="country_list">
                                <ul class="divide-y divide-gray-100 dark:divide-gray-600">
                                    <template x-for="country in itemsFiltered" :key="country.id">
                                        <li
                                            class="w-full text-left px-5 py-2 truncate text-gray-600 dark:text-gray-300 first-letter:uppercase
                                                hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none cursor-pointer"
                                            @click="$dispatch('states_loading'); $wire.setCountryBirthId(country.id); show = false; search = '';"
                                            :data-value="country.id"
                                        >
                                            <span class="mr-2 fi" :class=`fi-${country.iso2.toLowerCase()}`></span>
                                            <span x-text="country.name"></span>
                                        </li>
                                    </template>
                                </ul>

                                <template x-if="items.length && ! itemsFiltered.length && search.length">
                                    <div class="text-gray-400 italic text-xs text-center py-3">
                                        No hay coincidencias con su búsqueda.
                                    </div>
                                </template>

                                <template x-if="! items.length">
                                    <div class="text-gray-400 italic text-xs text-center py-3">
                                        No hay países disponibles.
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    @error('country_birth_id')
                        <p class="text-xs text-red-600 dark:text-red-300 mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div
                    class="relative mt-4"
                    x-data="
                        initCustomSelect({
                            items: @entangle('states'),
                            value: @entangle('state_birth_id'),
                            element: $refs.state_list,
                            setMethod: $wire.setStateBirthId,
                            eventLoading: 'cities',
                        })
                    "
                    x-init="$watch('search', value => currentElement = '')"
                    @states_loading.window="currentElement = ''; loading = true"
                    @states_loaded.window="loading = false"
                >
                    <x-label value="Estado de nacimiento" />

                    <div
                        class="w-full lg:w-3/4"
                        @mousedown.outside="show = false"
                        @keyup.esc="show = false"
                    >
                        <button
                            class="w-full mt-1 py-2 px-3 border text-left border-gray-300 dark:border-gray-700 dark:bg-gray-900
                                dark:text-gray-300 focus:ring-1 focus:outline-none focus:border-indigo-500 dark:focus:border-indigo-600
                                focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            type="button"
                            @click="show = ! show"
                            @keydown.tab="show = false"
                            @keyup.enter="show = true"
                            @keyup.up="show = true"
                            @keyup.down="show = true"
                        >
                            <div class="flex justify-between items-center">
                                <template x-if="! value">
                                    <span class="text-gray-400">Selecciona un estado / departamento</span>
                                </template>
                                <template x-if="value">
                                    <span x-text="selectedItem?.name"></span>
                                </template>

                                <div class="flex items-center gap-x-4">
                                    <template x-if="value">
                                        <span
                                            class="p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200 ease-in-out"
                                            @click.stop="$wire.setStateBirthId(0); $focus.focus($refs.search); $refs.state_list.scrollTo({ top: 0 });"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x w-3 h-3" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
                                        </span>
                                    </template>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-down w-5 h-5 text-gray-500" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9l6 6l6 -6" /></svg>
                                </div>
                            </div>
                        </button>

                        <div
                            class="absolute py-1 start-0 w-96 bg-white dark:bg-gray-700 rounded-md shadow-md border border-gray-200 dark:border-gray-600 z-50 overflow-x-hidden mt-2"
                            x-show="show"
                            x-trap.inert="show"
                            x-bind="dialog"
                        >
                            <div class="px-3 my-3">
                                <x-input
                                    class="w-full"
                                    type="search"
                                    x-ref="search"
                                    x-model="search"
                                    x-bind="input"
                                />
                            </div>

                            <div class="max-h-52 overflow-y-auto" x-ref="state_list">
                                <template x-if="loading">
                                    <div class="flex justify-center items-center py-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-loader animate-spin dark:text-white" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 6l0 -3" /><path d="M16.25 7.75l2.15 -2.15" /><path d="M18 12l3 0" /><path d="M16.25 16.25l2.15 2.15" /><path d="M12 18l0 3" /><path d="M7.75 16.25l-2.15 2.15" /><path d="M6 12l-3 0" /><path d="M7.75 7.75l-2.15 -2.15" /></svg>
                                    </div>
                                </template>

                                <template x-if="! loading">
                                    <ul class="divide-y divide-gray-100 dark:divide-gray-600">
                                        <template x-for="state in itemsFiltered" :key="state.id">
                                            <li
                                                class="w-full text-left px-5 py-2 truncate text-gray-600 dark:text-gray-300 first-letter:uppercase
                                                    hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none cursor-pointer"
                                                @click="$dispatch('cities_loading'); $wire.setStateBirthId(state.id); show = false; search = '';"
                                                :data-value="state.id"
                                            >
                                                <span x-text="state.name"></span>
                                            </li>
                                        </template>
                                    </ul>
                                </template>

                                <template x-if="items.length && ! itemsFiltered.length && search.length && ! loading">
                                    <div class="text-gray-400 italic text-xs text-center py-3">
                                        No hay coincidencias con su búsqueda.
                                    </div>
                                </template>

                                <template x-if="! items.length && ! loading">
                                    <div class="text-gray-400 italic text-xs text-center py-3">
                                        No hay estados disponibles.
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    @error('state_birth_id')
                        <p class="text-xs text-red-600 dark:text-red-300 mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div
                    class="relative mt-4"
                    x-data="
                        initCustomSelect({
                            items: @entangle('cities'),
                            value: @entangle('city_birth_id'),
                            element: $refs.city_list,
                            setMethod: $wire.setCityBirthId,
                        })
                    "
                    x-init="$watch('search', value => currentElement = '')"
                    @cities_loading.window="currentElement = ''; loading = true"
                    @cities_loaded.window="loading = false"
                >
                    <x-label value="Ciudad de nacimiento" />

                    <div
                        class="w-full lg:w-3/4"
                        @mousedown.outside="show = false"
                        @keyup.esc="show = false"
                    >
                        <button
                            class="w-full mt-1 py-2 px-3 border text-left border-gray-300 dark:border-gray-700 dark:bg-gray-900
                                dark:text-gray-300 focus:ring-1 focus:outline-none focus:border-indigo-500 dark:focus:border-indigo-600
                                focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            type="button"
                            @click="show = ! show"
                            @keydown.tab="show = false"
                            @keyup.enter="show = true"
                            @keyup.up="show = true"
                            @keyup.down="show = true"
                        >
                            <div class="flex justify-between items-center">
                                <template x-if="! value">
                                    <span class="text-gray-400">Selecciona una ciudad</span>
                                </template>
                                <template x-if="value">
                                    <span x-text="selectedItem?.name"></span>
                                </template>

                                <div class="flex items-center gap-x-4">
                                    <template x-if="value">
                                        <span
                                            class="p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200 ease-in-out"
                                            @click.stop="$wire.setCityBirthId(0); $focus.focus($refs.search); $refs.city_list.scrollTo({ top: 0 });"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x w-3 h-3" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
                                        </span>
                                    </template>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-down w-5 h-5 text-gray-500" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9l6 6l6 -6" /></svg>
                                </div>
                            </div>
                        </button>

                        <div
                            class="absolute py-1 start-0 w-96 bg-white dark:bg-gray-700 rounded-md shadow-md border border-gray-200 dark:border-gray-600 z-50 overflow-x-hidden mt-2"
                            x-show="show"
                            x-trap.inert="show"
                            x-bind="dialog"
                        >
                            <div class="px-3 my-3">
                                <x-input
                                    class="w-full"
                                    type="search"
                                    x-ref="search"
                                    x-model="search"
                                    x-bind="input"
                                />
                            </div>

                            <div class="max-h-52 overflow-y-auto" x-ref="city_list">
                                <template x-if="loading">
                                    <div class="flex justify-center items-center py-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-loader animate-spin dark:text-white" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 6l0 -3" /><path d="M16.25 7.75l2.15 -2.15" /><path d="M18 12l3 0" /><path d="M16.25 16.25l2.15 2.15" /><path d="M12 18l0 3" /><path d="M7.75 16.25l-2.15 2.15" /><path d="M6 12l-3 0" /><path d="M7.75 7.75l-2.15 -2.15" /></svg>
                                    </div>
                                </template>

                                <template x-if="! loading">
                                    <ul class="divide-y divide-gray-100 dark:divide-gray-600">
                                        <template x-for="city in itemsFiltered" :key="city.id">
                                            <li
                                                class="w-full text-left px-5 py-2 truncate text-gray-600 dark:text-gray-300 first-letter:uppercase
                                                    hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none cursor-pointer"
                                                @click="$wire.setCityBirthId(city.id); show = false; search = '';"
                                                :data-value="city.id"
                                            >
                                                <span x-text="city.name"></span>
                                            </li>
                                        </template>
                                    </ul>
                                </template>

                                <template x-if="items.length && ! itemsFiltered.length && search.length && ! loading">
                                    <div class="text-gray-400 italic text-xs text-center py-3">
                                        No hay coincidencias con su búsqueda.
                                    </div>
                                </template>

                                <template x-if="! items.length && ! loading">
                                    <div class="text-gray-400 italic text-xs text-center py-3">
                                        No hay ciudades disponibles.
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    @error('city_birth_id')
                        <p class="text-xs text-red-600 dark:text-red-300 mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mt-4">
                    <x-label value="Fecha de Defunción" />

                    <x-input
                        class="w-full lg:w-3/4 mt-1"
                        x-init="
                            new CustomDatepicker($el, {
                                format: 'dd/mm/yyyy',
                                autohide: true,
                                language: 'es',
                                clearBtn: true,
                                todayBtn: true,
                                title: 'Fecha de Defunción',
                            });

                            $el.addEventListener('changeDate', (event) => $wire.date_of_death = event.detail.date ? event.detail.date.toLocaleDateString('en-GB') : null);
                        "
                        x-mask="99/99/9999"
                    />

                    @error('date_of_death')
                        <p class="text-xs text-red-600 dark:text-red-300 mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mt-4">
                    <x-label value="Biografía" />

                    <div class="mt-1" wire:ignore>
                        <div id="biography"></div>
                    </div>

                    @error('biography')
                        <p class="text-xs text-red-600 dark:text-red-300 mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <hr class="my-4 -mx-6 dark:border-gray-700">

                <div class="flex justify-end gap-4">
                    <a
                        class="btn-sm flex items-center px-4 py-2 font-medium tracking-wide text-gray-600 capitalize
                        transition-colors duration-300 transform bg-white rounded-lg hover:bg-gray-50 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80"
                        href="{{ route('admin.authors.index') }}"
                        wire:navigate
                    >cancelar</a>

                    <x-primary-button
                        class="btn-sm"
                    >guardar</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</div>

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
                editor.model.document.on('change:data', () => {
                    $wire.biography = editor.getData();
                })
            })
            .catch(error => {
                console.error(error);
            });

        Alpine.data('initCustomSelect', ({ items, value, element, setMethod, eventLoading = '' }) => {
            return {
                show: false,
                search: '',
                items: items,
                value: value,
                currentElement: '',
                loading: false,
                eventLoading: eventLoading,
                input: initSearch(element, setMethod),
                dialog: initDialog(element, setMethod),
                get itemsFiltered() {
                    if (! this.search.length) return this.items

                    return this.items.filter(item => item.name.toLowerCase().includes(this.search.toLowerCase()) ? true : false)
                },
                get selectedItem() {
                    if (! this.value) return null

                    return this.items.find(item => item.id === this.value)
                },
            }
        });

        initSearch = function (element, setMethod) {
            return {
                ['@keydown.tab']() {
                    this.show = false
                },
                ['@keyup.tab']() {
                    this.show = true
                },
                ['@keydown.up']() {
                    event.preventDefault();

                    if (! this.currentElement) {
                        this.currentElement = element.getElementsByTagName('li')[0];

                        this.currentElement?.classList.add('focused');

                        return ;
                    }

                    if (this.currentElement.previousElementSibling?.nodeName === 'LI') {
                        this.currentElement.classList.remove('focused');

                        this.currentElement = this.currentElement.previousElementSibling;

                        this.currentElement.scrollIntoView();

                        this.currentElement.classList.add('focused');
                    }
                },
                ['@keydown.down']() {
                    if (! this.currentElement) {
                        this.currentElement = element.getElementsByTagName('li')[0];

                        this.currentElement?.classList.add('focused');

                        return ;
                    }

                    if (this.currentElement.nextSibling?.nodeName === 'LI') {
                        this.currentElement.classList.remove('focused');

                        this.currentElement = this.currentElement.nextSibling;

                        this.currentElement.scrollIntoView();

                        this.currentElement.classList.add('focused');
                    }
                },
                ['@keyup.enter']() {
                    if (! this.currentElement || ! this.currentElement.dataset.value) return ;

                    if (this.eventLoading) this.$dispatch(this.eventLoading + '_loading');

                    setMethod(this.currentElement.dataset.value);

                    this.show = false;

                    this.search = '';
                },
            }
        }

        initDialog = function (element, setMethod) {
            return {
                ['x-init']() {
                    this.$watch('show', (value) => {
                        if (! value) {
                            items = element.getElementsByClassName('focused');

                            for (i = 0; i < items.length; i++) {
                                items[i].classList.remove('focused');
                            }

                            return ;
                        }

                        this.$nextTick(() => element.scrollTo({ top: 0 }));

                        if (! this.value) return ;

                        const option = element.querySelector(`[data-value='${this.value}']`);

                        if (! option) return ;

                        this.currentElement = option;

                        this.currentElement.classList.add('focused');

                        this.$nextTick(() => this.currentElement.scrollIntoView());
                    })
                },
            }
        }
    </script>
@endscript
