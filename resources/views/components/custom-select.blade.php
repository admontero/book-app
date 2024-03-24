@php
    $items = $config['items'];
    $value = $config['value'];
    $element = $config['element'];
    $isMultiple = $config['isMultiple'] ?? false;
    $isCreatable = $config['isCreatable'] ?? false;
    $placeholder = $config['placeholder'] ?? 'Selecciona';
    $empty = $config['empty'] ?? 'No hay opciones disponibles';
    $listeners = $listeners ?? [];
@endphp

<div
    class="{{ $containerClass }}"
    x-data="initCustomSelect({
        items: @entangle($attributes->get('config')['items']),
        value: @entangle($attributes->get('config')['value']),
        element: {{ '$refs.' . $element }},
        isMultiple: {{ Illuminate\Support\Js::from($isMultiple) }},
        isCreatable: {{ Illuminate\Support\Js::from($isCreatable) }},
        property: '{{ $value }}',
    })"
    x-init="$watch('search', value => currentFocus = '')"
    @mousedown.outside="show = false"
    @keyup.esc="show = false"
    @reset-search.window="search = ''"
    @foreach ($listeners as $key => $value)
        {{ '@' . $key }}="{{ $value }}"
    @endforeach
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
            <template x-if="isEmpty">
                <span class="text-gray-400">{{ $placeholder }}</span>
            </template>

            <template x-if="! isEmpty && isMultiple">
                <span x-text="selected?.map(item => item.label.charAt(0).toUpperCase() + item.label.slice(1)).join(', ')"></span>
            </template>

            <template x-if="! isEmpty && ! isMultiple">
                <div class="flex items-center">
                    {{ $selectionContainer ?? null }}
                    <span class="capitalize" x-text="selected?.label"></span>
                </div>
            </template>

            <div class="flex items-center gap-x-4">
                <template x-if="! isEmpty">
                    <span
                        class="p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200 ease-in-out"
                        @click.stop="$dispatch('update', { value: null })"
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

            {{ $validationInput ?? null }}
        </div>

        <div class="max-h-52 overflow-y-auto" x-ref="{{ $element }}">
            <template x-if="loading">
                <div class="flex justify-center items-center py-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-loader animate-spin dark:text-white" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 6l0 -3" /><path d="M16.25 7.75l2.15 -2.15" /><path d="M18 12l3 0" /><path d="M16.25 16.25l2.15 2.15" /><path d="M12 18l0 3" /><path d="M7.75 16.25l-2.15 2.15" /><path d="M6 12l-3 0" /><path d="M7.75 7.75l-2.15 -2.15" /></svg>
                </div>
            </template>

            <template x-if="! loading">
                <ul class="divide-y divide-gray-100 dark:divide-gray-600">
                    <template x-if="search.length && isCreatable && ! isIncluded">
                        <li
                            class="flex items-center w-full text-left px-5 py-2 truncate text-gray-600 dark:text-gray-300
                            hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none cursor-pointer"
                            @click="$dispatch('create')"
                        >
                            <span class="first-letter:uppercase">crear:
                                <span class="text-blue-600 dark:text-blue-400" x-text="search"></span>
                            </span>
                        </li>
                    </template>

                    <template x-for="item in itemsFiltered" :key="item.value">
                        <li
                            class="flex items-center w-full text-left px-5 py-2 truncate text-gray-600 dark:text-gray-300 capitalize
                                hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none cursor-pointer"
                            @click="$dispatch('update', { value: item.value }); if (! isMultiple) { show = false; search = ''; }"
                            :data-value="item.value"
                        >
                            {{ $optionContainer ?? false }}

                            <template x-if="isMultiple">
                                <div>
                                    <svg x-show="! value.includes(item.value)" class="icon icon-tabler icons-tabler-outline icon-tabler-square w-5 h-5 me-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" /></svg>
                                    <svg x-show="value.includes(item.value)" class="icon icon-tabler icons-tabler-outline icon-tabler-square-check w-5 h-5 me-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" /><path d="M9 12l2 2l4 -4" /></svg>
                                </div>
                            </template>

                            <span x-text="item.label"></span>
                        </li>
                    </template>
                </ul>
            </template>

            <template x-if="items.length && ! itemsFiltered.length && search.length && ! isCreatable && ! loading">
                <div class="text-gray-400 italic text-xs text-center py-3">
                    No hay coincidencias con su búsqueda.
                </div>
            </template>

            <template x-if="! items.length && ! loading">
                <div class="text-gray-400 italic text-xs text-center py-3">
                    {{ $empty }}
                </div>
            </template>
        </div>
    </div>
</div>

@script
    <script>
        Alpine.data('initCustomSelect', ({ items, value, element, isMultiple = false, isCreatable = false, property }) => {
            return {
                show: false,
                search: '',
                items: items,
                value: value,
                property: property,
                element: element,
                currentFocus: null,
                loading: false,
                isMultiple: isMultiple,
                isCreatable: isCreatable,
                input: initSearch(),
                dialog: initDialog(),
                get itemsSorted() {
                    return this.items.sort((a, b) => a.label.toLowerCase().localeCompare(b.label.toLowerCase()));
                },
                get itemsFiltered() {
                    if (! this.search.length) return this.itemsSorted;

                    return this.itemsSorted.filter(item => item.label.toLowerCase().includes(this.search.toLowerCase()));
                },
                get selected() {
                    if (! isMultiple) {
                        if (! this.value) return null;

                        return this.items.find(item => item.value == this.value);
                    }

                    if (! this.value || ! this.value.length) return null;

                    return this.items.filter(item => this.value.includes(item.value));
                },
                get isEmpty() {
                    if (this.isMultiple) return ! this.value.length;

                    return ! this.value;
                },
                get isIncluded() {
                    if (! this.search.length) return false;

                    return this.items.some(item => item.label.toLowerCase() === this.search.toLowerCase());
                },
                resetValue() {
                    if (this.isMultiple) {
                        this.setProperty(this.property, []);
                    } else {
                        this.setProperty(this.property, null);
                    }

                    $focus.focus($refs.search);

                    this.element.scrollTo({ top: 0 });
                },
                setProperty(path, value) {
                    var schema = $wire;

                    var properties = path.split('.');

                    var len = properties.length;

                    for (let i = 0; i < len - 1; i++) {
                        var element = properties[i];

                        if (! schema[element]) schema[element] = {};

                        schema = schema[element];
                    }

                    schema[properties[len - 1]] = value;
                },
            }
        });

        initSearch = function () {
            return {
                ['@keydown.tab']() {
                    this.show = false
                },
                ['@keyup.tab']() {
                    this.show = true
                },
                ['@keydown.up']() {
                    event.preventDefault();

                    if (! this.currentFocus) {
                        this.currentFocus = this.element.getElementsByTagName('li')[0];

                        this.currentFocus?.classList.add('focused');

                        return ;
                    }

                    let previous = this.currentFocus.previousElementSibling;

                    while (previous && previous.nodeName !== 'LI') {
                        previous = previous.previousElementSibling;
                    }

                    if (previous) {
                        this.currentFocus.classList.remove('focused');

                        this.currentFocus = previous;

                        this.currentFocus.scrollIntoView();

                        this.currentFocus.classList.add('focused');
                    }
                },
                ['@keydown.down']() {
                    if (! this.currentFocus) {
                        this.currentFocus = this.element.getElementsByTagName('li')[0];

                        this.currentFocus?.classList.add('focused');

                        return ;
                    }

                    let next = this.currentFocus.nextElementSibling;

                    while (next && next.nodeName !== 'LI') {
                        next = next.nextElementSibling;
                    }

                    if (next) {
                        this.currentFocus.classList.remove('focused');

                        this.currentFocus = next;

                        this.currentFocus.scrollIntoView();

                        this.currentFocus.classList.add('focused');
                    }
                },
                ['@keyup.enter']() {
                    if (! this.currentFocus) return ;

                    if (! this.currentFocus.dataset.value && this.isCreatable) {
                        this.$dispatch('create');

                        return ;
                    }

                    this.$dispatch('update', { value: this.currentFocus.dataset.value });

                    if (! this.isMultiple) {
                        this.show = false;

                        this.search = '';
                    }
                },
            }
        }

        initDialog = function () {
            return {
                ['x-init']() {
                    this.$watch('show', (value) => {
                        if (! value) {
                            items = this.element.getElementsByClassName('focused');

                            for (i = 0; i < items.length; i++) {
                                items[i].classList.remove('focused');
                            }

                            return ;
                        }

                        this.$nextTick(() => this.element.scrollTo({ top: 0 }));

                        if (! this.value) return ;

                        const option = this.isMultiple
                            ? this.element.querySelector(`[data-value='${this.value[0]}']`)
                            : this.element.querySelector(`[data-value='${this.value}']`);

                        if (! option) return ;

                        this.currentFocus = option;

                        this.currentFocus.classList.add('focused');

                        this.$nextTick(() => this.currentFocus.scrollIntoView());
                    })
                },
            }
        }
    </script>
@endscript
