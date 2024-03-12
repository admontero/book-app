<div class="max-w-7xl mx-auto lg:flex gap-4 px-4">
    <div class="lg:w-4/12 2xl:w-3/12">

    </div>

    <div class="lg:w-8/12 2xl:w-9/12">
        <div class="px-6 py-4 bg-white dark:bg-gray-800 rounded-md border border-gray-200 dark:border-gray-700 mt-4 lg:mt-0">
            <form wire:submit.prevent="save">
                <h2 class="inline-flex items-center text-gray-700 dark:text-white font-medium text-lg">
                    <svg class="icon icon-tabler icon-tabler-edit w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                    Edición de Autor
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
                            const datebirthpicker = new CustomDatepicker($el, {
                                format: 'dd/mm/yyyy',
                                autohide: true,
                                language: 'es',
                                clearBtn: true,
                                todayBtn: true,
                                title: 'Fecha de Nacimiento',
                            });

                            datebirthpicker.setDate($wire.date_of_birth)

                            $el.addEventListener('changeDate', (event) => $wire.date_of_birth = event.detail.date ? event.detail.date.toLocaleDateString('en-GB') : null);
                        "
                        x-mask="99/99/9999"
                        x-ref="date_of_birth"
                    />

                    @error('date_of_birth')
                        <p class="text-xs text-red-600 dark:text-red-300 mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div
                    class="relative mt-4"
                    x-data="{
                        show: false,
                        search: '',
                        countries: {{ Illuminate\Support\Js::from($countries) }},
                        country_birth_id: @entangle('country_birth_id'),
                        get countriesSorted() {
                            return this.countries.sort((a, b) => a.name.toLowerCase().localeCompare(b.name.toLowerCase()))
                        },
                        get countriesFiltered() {
                            if (! this.search.length) return this.countriesSorted

                            return this.countriesSorted.filter(country => country.name.toLowerCase().includes(this.search.toLowerCase()) ? true : false)
                        },
                        get selectedCountry() {
                            if (! this.country_birth_id) return null

                            return this.countries.find(country => country.id === this.country_birth_id)
                        }
                    }"
                    wire:key="countrySelector"
                >
                    <x-label value="País de nacimiento" />

                    <div
                        @mousedown.outside="show = false"
                        @keyup.esc="show = false"
                        class="w-full lg:w-3/4"
                    >
                        <button
                            class="w-full mt-1 py-2 px-3 border text-left border-gray-300 dark:border-gray-700 dark:bg-gray-900
                                dark:text-gray-300 focus:ring-1 focus:outline-none focus:border-indigo-500 dark:focus:border-indigo-600
                                focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            @click="show = ! show"
                            @keydown.tab="show = false"
                            @keyup.tab="show = true"
                            type="button"
                        >
                            <div class="flex justify-between items-center">
                                <template x-if="! country_birth_id">
                                    <span class="text-gray-400">Selecciona un país</span>
                                </template>
                                <template x-if="country_birth_id">
                                    <div>
                                        <span class="mr-2 fi" :class=`fi-${selectedCountry?.iso2.toLowerCase()}`></span>
                                        <span x-text="selectedCountry?.name"></span>
                                    </div>
                                </template>

                                <div class="flex items-center gap-x-4">
                                    <template x-if="country_birth_id">
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
                            x-show="show"
                            @keydown.up="$focus.wrap().previous()"
                            @keydown.down="$focus.wrap().next()"
                            x-trap.inert.noautofocus="show"
                            x-init="$watch('show', (value) => {
                                    if (! value) return ;

                                    $nextTick(() => $refs.country_list.scrollTo({ top: 0 }));

                                    if (! country_birth_id) return $focus.focus($refs.search);

                                    const button = document.querySelector('#country-' + country_birth_id);

                                    if (!button) return ;

                                    $focus.noscroll().focus(button);

                                    $nextTick(() => button.scrollIntoView({ behavior: 'smooth', block: 'center' }));
                                })
                            "
                            class="absolute py-1 start-0 w-96 bg-white dark:bg-gray-700 rounded-md shadow-md border border-gray-200 dark:border-gray-600 z-50 overflow-x-hidden mt-2"
                        >
                            <div class="px-3 my-3">
                                <x-input x-ref="search" class="w-full" type="search" x-model="search" />
                            </div>

                            <div class="max-h-52 overflow-y-auto" x-ref="country_list">
                                <ul class="divide-y divide-gray-100 dark:divide-gray-600">
                                    <template x-for="country in countriesFiltered" :key="country.id">
                                        <li>
                                            <button
                                                type="button"
                                                class="w-full text-left px-5 py-2 truncate text-gray-600 dark:text-gray-300 first-letter:uppercase
                                                    hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none focus:bg-gray-100"
                                                :class="country_birth_id == country.id ? 'bg-gray-100 dark:bg-gray-600' : 'bg-white dark:bg-gray-700'"
                                                @click="$wire.setCountryBirthId(country.id); show = false; search = '';"
                                                :id=`country-${country.id}`
                                            >

                                                <span class="mr-2 fi" :class=`fi-${country.iso2.toLowerCase()}`></span>
                                                <span x-text="country.name"></span>
                                            </button>
                                        </li>
                                    </template>

                                    <template x-if="countries.length && ! countriesFiltered.length && search.length">
                                        <li class="text-gray-400 italic text-xs text-center py-3">
                                            No hay coincidencias con su búsqueda.
                                        </li>
                                    </template>

                                    <template x-if="! countries.length">
                                        <li class="text-gray-400 italic text-xs text-center py-3">
                                            No hay países disponibles.
                                        </li>
                                    </template>
                                </ul>
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
                    x-data="{
                        show: false,
                        search: '',
                        states: @entangle('states'),
                        state_birth_id: @entangle('state_birth_id'),
                        get statesFiltered() {
                            if (! this.search.length) return this.states

                            return this.states.filter(state => state.name.toLowerCase().includes(this.search.toLowerCase()) ? true : false)
                        },
                        get selectedState() {
                            if (! this.state_birth_id) return null

                            return this.states.find(state => state.id === this.state_birth_id)
                        },
                    }"
                    wire:key="stateSelector"
                >
                    <x-label value="Estado de nacimiento" />

                    <div
                        @mousedown.outside="show = false"
                        @keyup.esc="show = false"
                        class="w-full lg:w-3/4"
                    >
                        <button
                            class="w-full mt-1 py-2 px-3 border text-left border-gray-300 dark:border-gray-700 dark:bg-gray-900
                                dark:text-gray-300 focus:ring-1 focus:outline-none focus:border-indigo-500 dark:focus:border-indigo-600
                                focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            @click="show = ! show"
                            @keydown.tab="show = false"
                            @keyup.tab="show = true"
                            type="button"
                        >
                            <div class="flex justify-between items-center">
                                <template x-if="! state_birth_id">
                                    <span class="text-gray-400">Selecciona un estado / departamento</span>
                                </template>
                                <template x-if="state_birth_id">
                                    <span x-text="selectedState?.name"></span>
                                </template>

                                <div class="flex items-center gap-x-4">
                                    <template x-if="state_birth_id">
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
                            x-show="show"
                            @keydown.up="$focus.wrap().previous()"
                            @keydown.down="$focus.wrap().next()"
                            x-trap.inert.noautofocus="show"
                            x-init="$watch('show', (value) => {
                                    if (! value) return ;

                                    $nextTick(() => $refs.state_list.scrollTo({ top: 0 }));

                                    if (! state_birth_id) return $focus.focus($refs.search);

                                    const button = document.querySelector('#state-' + state_birth_id);

                                    if (!button) return ;

                                    $focus.noscroll().focus(button);

                                    $nextTick(() => button.scrollIntoView({ behavior: 'smooth', block: 'center' }));
                                })
                            "
                            class="absolute py-1 start-0 w-96 bg-white dark:bg-gray-700 rounded-md shadow-md border border-gray-200 dark:border-gray-600 z-50 overflow-x-hidden mt-2"
                        >
                            <div class="px-3 my-3">
                                <x-input x-ref="search" class="w-full" type="search" x-model="search" />
                            </div>

                            <div class="max-h-52 overflow-y-auto" x-ref="state_list">
                                <ul class="divide-y divide-gray-100 dark:divide-gray-600">
                                    <template x-for="state in statesFiltered" :key="state.id">
                                        <li>
                                            <button
                                                type="button"
                                                x-text="state.name"
                                                class="w-full text-left px-5 py-2 truncate text-gray-600 dark:text-gray-300 first-letter:uppercase
                                                    hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none focus:bg-gray-100"
                                                :class="state_birth_id == state.id ? 'bg-gray-100 dark:bg-gray-600' : 'bg-white dark:bg-gray-700'"
                                                @click="$wire.setStateBirthId(state.id); show = false; search = '';"
                                                :id=`state-${state.id}`
                                            ></button>
                                        </li>
                                    </template>

                                    <template x-if="states.length && ! statesFiltered.length && search.length">
                                        <li class="text-gray-400 italic text-xs text-center py-3">
                                            No hay coincidencias con su búsqueda.
                                        </li>
                                    </template>

                                    <template x-if="! states.length">
                                        <li class="text-gray-400 italic text-xs text-center py-3">
                                            No hay estados disponibles.
                                        </li>
                                    </template>
                                </ul>
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
                    x-data="{
                        show: false,
                        search: '',
                        cities: @entangle('cities'),
                        city_birth_id: @entangle('city_birth_id'),
                        get citiesFiltered() {
                            if (! this.search.length) return this.cities

                            return this.cities.filter(city => city.name.toLowerCase().includes(this.search.toLowerCase()) ? true : false)
                        },
                        get selectedCity() {
                            if (! this.city_birth_id) return null

                            return this.cities.find(city => city.id === this.city_birth_id)
                        },
                    }"
                    wire:key="citySelector"
                >
                    <x-label value="Ciudad de nacimiento" />

                    <div
                        @mousedown.outside="show = false"
                        @keyup.esc="show = false"
                        class="w-full lg:w-3/4"
                    >
                        <button
                            class="w-full mt-1 py-2 px-3 border text-left border-gray-300 dark:border-gray-700 dark:bg-gray-900
                                dark:text-gray-300 focus:ring-1 focus:outline-none focus:border-indigo-500 dark:focus:border-indigo-600
                                focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            @click="show = ! show"
                            @keydown.tab="show = false"
                            @keyup.tab="show = true"
                            type="button"
                        >
                            <div class="flex justify-between items-center">
                                <template x-if="! city_birth_id">
                                    <span class="text-gray-400">Selecciona una ciudad</span>
                                </template>
                                <template x-if="city_birth_id">
                                    <span x-text="selectedCity?.name"></span>
                                </template>

                                <div class="flex items-center gap-x-4">
                                    <template x-if="city_birth_id">
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
                            x-show="show"
                            @keydown.up="$focus.wrap().previous()"
                            @keydown.down="$focus.wrap().next()"
                            x-trap.inert.noautofocus="show"
                            x-init="$watch('show', (value) => {
                                    if (! value) return ;

                                    $nextTick(() => $refs.city_list.scrollTo({ top: 0 }));

                                    if (! city_birth_id) return $focus.focus($refs.search);

                                    const button = document.querySelector('#city-' + city_birth_id);

                                    if (!button) return ;

                                    $focus.noscroll().focus(button);

                                    $nextTick(() => button.scrollIntoView({ behavior: 'smooth', block: 'center' }));
                                })
                            "
                            class="absolute py-1 start-0 w-96 bg-white dark:bg-gray-700 rounded-md shadow-md border border-gray-200 dark:border-gray-600 z-50 overflow-x-hidden mt-2"
                        >
                            <div class="px-3 my-3">
                                <x-input x-ref="search" class="w-full" type="search" x-model="search" />
                            </div>

                            <div class="max-h-52 overflow-y-auto" x-ref="city_list">
                                <ul class="divide-y divide-gray-100 dark:divide-gray-600">
                                    <template x-for="city in citiesFiltered" :key="city.id">
                                        <button
                                            type="button"
                                            x-text="city.name"
                                            class="w-full text-left px-5 py-2 truncate text-gray-600 dark:text-gray-300 first-letter:uppercase
                                                hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none focus:bg-gray-100"
                                            :class="city_birth_id == city.id ? 'bg-gray-100 dark:bg-gray-600' : 'bg-white dark:bg-gray-700'"
                                            @click="$wire.setCityBirthId(city.id); show = false; search = '';"
                                            :id=`city-${city.id}`
                                        ></button>
                                    </template>

                                    <template x-if="cities.length && ! citiesFiltered.length && search.length">
                                        <li class="text-gray-400 italic text-xs text-center py-3">
                                            No hay coincidencias con su búsqueda.
                                        </li>
                                    </template>

                                    <template x-if="! cities.length">
                                        <li class="text-gray-400 italic text-xs text-center py-3">
                                            No hay ciudades disponibles.
                                        </li>
                                    </template>
                                </ul>
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
                            const datedeathpicker = new CustomDatepicker($el, {
                                format: 'dd/mm/yyyy',
                                autohide: true,
                                language: 'es',
                                clearBtn: true,
                                todayBtn: true,
                                title: 'Fecha de Defunción',
                            });

                            datedeathpicker.setDate($wire.date_of_death)

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

                editor.setData($wire.biography)

                editor.model.document.on('change:data', () => {
                    $wire.biography = editor.getData();
                })
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endscript
