<div class="max-w-7xl mx-auto lg:flex gap-4 px-4">
    <div class="lg:w-4/12 2xl:w-3/12">

    </div>

    <div class="lg:w-8/12 2xl:w-9/12">
        <div class="px-6 py-4 bg-white dark:bg-gray-800 rounded-md border border-gray-200 dark:border-gray-700 mt-4 lg:mt-0">
            <form wire:submit.prevent="save" @keydown.enter="event.preventDefault()">
                <h2 class="inline-flex items-center text-gray-700 dark:text-white font-medium text-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-plus w-5 h-5 mr-2" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M9 12h6" /><path d="M12 9v6" /></svg>
                    Nuevo Libro
                </h2>

                <hr class="my-4 -mx-6 dark:border-gray-700">

                <div>
                    <x-label value="Título" />

                    <x-input
                        class="w-full lg:w-3/4 mt-1"
                        wire:model="title"
                        x-ref="title"
                        x-init="$focus.focus($el)"
                    />

                    @error('title')
                        <p class="text-xs text-red-600 dark:text-red-300 mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mt-4">
                    <x-label value="Año de Publicación" />

                    <x-input
                        class="w-full lg:w-3/4 mt-1"
                        wire:model="publication_year"
                    />

                    @error('publication_year')
                        <p class="text-xs text-red-600 dark:text-red-300 mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div
                    class="relative mt-4"
                    x-data="
                        initSingleSelect({
                            items: {{ Illuminate\Support\Js::from($authors) }},
                            value: @entangle('author_id'),
                            element: $refs.author_list,
                            property: 'author_id',
                        })
                    "
                    x-init="$watch('search', value => currentElement = '')"
                >
                    <x-label value="Autor" />

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
                                    <span class="text-gray-400">Selecciona un autor</span>
                                </template>
                                <template x-if="value">
                                    <span class="capitalize" x-text="selectedItem?.name"></span>
                                </template>

                                <div class="flex items-center gap-x-4">
                                    <template x-if="value">
                                        <span
                                            class="p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200 ease-in-out"
                                            @click.stop="$wire.author_id = null; $focus.focus($refs.search); $refs.author_list.scrollTo({ top: 0 });"
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

                            <div class="max-h-52 overflow-y-auto" x-ref="author_list">
                                <ul class="divide-y divide-gray-100 dark:divide-gray-600">
                                    <template x-for="author in itemsFiltered" :key="author.id">
                                        <li
                                            class="w-full text-left px-5 py-2 truncate text-gray-600 dark:text-gray-300 capitalize
                                                hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none cursor-pointer"
                                            @click="$wire.author_id = author.id; show = false; search = '';"
                                            :data-value="author.id"
                                        >
                                            <span x-text="author.name"></span>
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
                                        No hay autores disponibles.
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    @error('author_id')
                        <p class="text-xs text-red-600 dark:text-red-300 mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div
                    class="relative mt-4"
                    x-data="
                        initMultipleSelect({
                            items: {{ Illuminate\Support\Js::from($genres) }},
                            value: @entangle('genre_ids'),
                            element: $refs.genre_list,
                            setMethod: $wire.setGenreIds,
                        })
                    "
                    x-init="$watch('search', value => currentElement = '')"
                >
                    <x-label value="Géneros" />

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
                                <template x-if="! value.length">
                                    <span class="text-gray-400">Selecciona uno o varios géneros</span>
                                </template>
                                <template x-if="value.length">
                                    <span x-text="selectedItems.map(genre => genre.name.charAt(0).toUpperCase() + genre.name.slice(1)).join(', ')"></span>
                                </template>

                                <div class="flex items-center gap-x-4">
                                    <template x-if="value.length">
                                        <span
                                            class="p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200 ease-in-out"
                                            @click.stop="$wire.genre_ids = []; $focus.focus($refs.search); $refs.genre_list.scrollTo({ top: 0 });"
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

                            <div class="max-h-52 overflow-y-auto" x-ref="genre_list">
                                <ul class="divide-y divide-gray-100 dark:divide-gray-600">
                                    <template x-for="genre in itemsFiltered" :key="genre.id">
                                        <li
                                            class="flex items-center w-full text-left px-5 py-2 truncate text-gray-600 dark:text-gray-300 capitalize
                                                hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none cursor-pointer"
                                            @click="$wire.setGenreIds(genre.id);"
                                            :data-value="genre.id"
                                        >
                                            <svg x-show="! value.includes(genre.id)" class="icon icon-tabler icons-tabler-outline icon-tabler-square w-5 h-5 me-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" /></svg>
                                            <svg x-show="value.includes(genre.id)" class="icon icon-tabler icons-tabler-outline icon-tabler-square-check w-5 h-5 me-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" /><path d="M9 12l2 2l4 -4" /></svg>
                                            <span x-text="genre.name"></span>
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
                                        No hay géneros disponibles.
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    @error('genre_ids')
                        <p class="text-xs text-red-600 dark:text-red-300 mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mt-4">
                    <x-label class="w-full lg:w-3/4 flex justify-between">
                        <span>Sinopsis</span>

                        <p class="text-xs text-gray-600 dark:text-gray-300 mt-1" :class="$wire.synopsis.length > 800 ? 'text-red-600 dark:text-red-300' : ''">
                            <span x-text="$wire.synopsis.length"></span>
                            <span>/ 800</span>
                        </p>
                    </x-label>

                    <textarea
                        class="w-full lg:w-3/4 mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300
                            focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md
                            shadow-sm"
                        wire:model="synopsis"
                        rows="8"
                        x-data
                        x-autosize
                    ></textarea>

                    @error('synopsis')
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
                        href="{{ route('admin.books.index') }}"
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
        Alpine.data('initSingleSelect', ({ items, value, element, property }) => {
            return {
                show: false,
                search: '',
                items: items,
                value: value,
                currentElement: '',
                loading: false,
                input: initSearch(element, property),
                dialog: initDialog(element),
                get itemsFiltered() {
                    if (! this.search.length) return this.items

                    return this.items.filter(item => item.name.toLowerCase().includes(this.search.toLowerCase()) ? true : false)
                },
                get selectedItem() {
                    if (! this.value) return null

                    return this.items.find(item => item.id == this.value)
                },
            }
        });

        initSearch = function (element, property) {
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

                    $wire[property] = this.currentElement.dataset.value;

                    this.show = false;

                    this.search = '';
                },
            }
        }

        initDialog = function (element) {
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

        Alpine.data('initMultipleSelect', ({ items, value, element, setMethod }) => {
            return {
                show: false,
                search: '',
                items: items,
                value: value,
                currentElement: '',
                loading: false,
                input: initSearchMultiple(element, setMethod),
                dialog: initDialogMultiple(element, setMethod),
                get itemsFiltered() {
                    if (! this.search.length) return this.items

                    return this.items.filter(item => item.name.toLowerCase().includes(this.search.toLowerCase()) ? true : false)
                },
                get selectedItems() {
                    if (! this.value.length) return null

                    return this.items.filter(item => this.value.includes(item.id))
                },
            }
        });

        initSearchMultiple = function (element, setMethod) {
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

                    setMethod(this.currentElement.dataset.value);
                },
            }
        }

        initDialogMultiple = function (element, setMethod) {
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

                        if (! this.value.length) return ;

                        const option = element.querySelector(`[data-value='${this.value[0]}']`);

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
