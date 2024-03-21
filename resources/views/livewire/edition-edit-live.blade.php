<div class="max-w-7xl mx-auto lg:flex gap-4 px-4">
    <div class="lg:w-4/12 2xl:w-3/12">

    </div>

    <div class="lg:w-8/12 2xl:w-9/12">
        <div class="px-6 py-4 bg-white dark:bg-gray-800 rounded-md border border-gray-200 dark:border-gray-700 mt-4 lg:mt-0">
            <form wire:submit.prevent="save" @keydown.enter="event.preventDefault()">
                <h2 class="inline-flex items-center text-gray-700 dark:text-white font-medium text-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-plus w-5 h-5 mr-2" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M9 12h6" /><path d="M12 9v6" /></svg>
                    Actualización de Edición
                </h2>

                <hr class="my-4 -mx-6 dark:border-gray-700">

                <div
                    class="relative"
                    x-data="
                        initSingleSelect({
                            items: {{ Illuminate\Support\Js::from($books) }}
                                .map(({ id, title }) => ({ id, name: title })),
                            value: @entangle('book_id'),
                            element: $refs.book_list,
                            property: 'book_id',
                        })
                    "
                    x-init="$watch('search', value => currentElement = '')"
                >
                    <x-label value="Libro" />

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
                            x-init="$focus.focus($el)"
                            @click="show = ! show"
                            @keydown.tab="show = false"
                            @keyup.enter="show = true"
                            @keyup.up="show = true"
                            @keyup.down="show = true"
                        >
                            <div class="flex justify-between items-center">
                                <template x-if="! value">
                                    <span class="text-gray-400">Selecciona el libro</span>
                                </template>
                                <template x-if="value">
                                    <span class="capitalize" x-text="selectedItem?.name"></span>
                                </template>

                                <div class="flex items-center gap-x-4">
                                    <template x-if="value">
                                        <span
                                            class="p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200 ease-in-out"
                                            @click.stop="$wire.book_id = null; $focus.focus($refs.search); $refs.book_list.scrollTo({ top: 0 });"
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

                            <div class="max-h-52 overflow-y-auto" x-ref="book_list">
                                <ul class="divide-y divide-gray-100 dark:divide-gray-600">
                                    <template x-for="book in itemsFiltered" :key="book.id">
                                        <li
                                            class="w-full text-left px-5 py-2 truncate text-gray-600 dark:text-gray-300 capitalize
                                                hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none cursor-pointer"
                                            @click="$wire.book_id = book.id; show = false; search = '';"
                                            :data-value="book.id"
                                        >
                                            <span x-text="book.name"></span>
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
                                        No hay libros disponibles.
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    @error('book_id')
                        <p class="text-xs text-red-600 dark:text-red-300 mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div
                    class="relative mt-4"
                    x-data="
                        initSingleSelect({
                            items: {{ Illuminate\Support\Js::from($editorials) }},
                            value: @entangle('editorial_id'),
                            element: $refs.editorial_list,
                            property: 'editorial_id',
                        })
                    "
                    x-init="$watch('search', value => currentElement = '')"
                >
                    <x-label value="Editorial" />

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
                            x-init="$focus.focus($el)"
                            @click="show = ! show"
                            @keydown.tab="show = false"
                            @keyup.enter="show = true"
                            @keyup.up="show = true"
                            @keyup.down="show = true"
                        >
                            <div class="flex justify-between items-center">
                                <template x-if="! value">
                                    <span class="text-gray-400">Selecciona la editorial</span>
                                </template>
                                <template x-if="value">
                                    <span class="capitalize" x-text="selectedItem?.name"></span>
                                </template>

                                <div class="flex items-center gap-x-4">
                                    <template x-if="value">
                                        <span
                                            class="p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200 ease-in-out"
                                            @click.stop="$wire.editorial_id = null; $focus.focus($refs.search); $refs.editorial_list.scrollTo({ top: 0 });"
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

                            <div class="max-h-52 overflow-y-auto" x-ref="editorial_list">
                                <ul class="divide-y divide-gray-100 dark:divide-gray-600">
                                    <template x-for="editorial in itemsFiltered" :key="editorial.id">
                                        <li
                                            class="w-full text-left px-5 py-2 truncate text-gray-600 dark:text-gray-300 capitalize
                                                hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none cursor-pointer"
                                            @click="$wire.editorial_id = editorial.id; show = false; search = '';"
                                            :data-value="editorial.id"
                                        >
                                            <span x-text="editorial.name"></span>
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
                                        No hay editoriales disponibles.
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    @error('editorial_id')
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
                    <x-label value="Portada" />

                    <input
                        class="block w-full lg:w-3/4 px-3 py-1.5 mt-1 text-sm text-gray-600 border border-gray-300 dark:border-gray-700 dark:bg-gray-900
                            rounded-md file:bg-gray-200 file:text-gray-700 file:text-sm file:px-4 file:py-1 file:border-none file:rounded-full
                            dark:file:bg-gray-800 dark:file:text-gray-200 dark:text-gray-300 placeholder-gray-400/70 dark:placeholder-gray-500
                            focus:outline-none focus:ring-1 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"
                        wire:model="cover"
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

                    @if ($cover)
                        <div class="w-full lg:w-3/4">
                            <img class="mx-auto mt-2" style="height: 300px;" src="{{ $cover->temporaryUrl() }}">
                        </div>
                    @endif

                    @error('cover')
                        <p class="text-xs text-red-600 dark:text-red-300 mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mt-4">
                    <x-label value="ISBN13" />

                    <x-input
                        class="w-full lg:w-3/4 mt-1"
                        wire:model="isbn13"
                        x-mask="9999999999999"
                    />

                    @error('isbn13')
                        <p class="text-xs text-red-600 dark:text-red-300 mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mt-4">
                    <x-label value="Año" />

                    <x-input
                        class="w-full lg:w-3/4 mt-1"
                        wire:model="year"
                        x-mask="9999"
                    />

                    @error('year')
                        <p class="text-xs text-red-600 dark:text-red-300 mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mt-4">
                    <x-label value="Páginas" />

                    <x-input
                        class="w-full lg:w-3/4 mt-1"
                        wire:model="pages"
                    />

                    @error('pages')
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
                        href="{{ route('admin.editions.index') }}"
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
    </script>
@endscript
