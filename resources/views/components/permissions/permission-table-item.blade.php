<tr wire:key="permission-{{ $permission->id }}">
    <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
        <h2 class="font-medium text-gray-800 dark:text-white">{{ App\Enums\PermissionEnum::options()[$permission->name] }}</h2>
        <dl class="lg:hidden">
            <dt class="sr-only"># Usuarios</dt>
            <dd class="font-normal text-xs text-gray-600 dark:text-gray-400 truncate mt-1">
                @if ($permission->users_count)
                    <p>
                        {{ $permission->users_count }} Usuario(s)
                    </p>
                @else
                    <span class="italic">Sin usuarios</span>
                @endif
            </dd>
        </dl>
    </td>

    <td class="hidden lg:table-cell px-4 py-4 text-sm whitespace-nowrap">
        <div x-data="{ show: false }" class="flex items-center">
            @forelse ($permission->users->take(4) as $user)
                <a
                    class="object-cover shrink-0 -mx-1.5 flex text-sm border-2 border-white dark:border-gray-600
                        rounded-full focus:outline-none focus:border-gray-300"
                    href="{{ route('admin.users.show', $user) }}"
                    wire:key="{{ $user->id }}"
                >
                    <img class="w-6 h-6 rounded-full" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" />
                </a>
            @empty
                <span class="italic text-xs text-gray-600 dark:text-gray-400">Sin usuarios</span>
            @endforelse
            @if ($permission->users_count > 4)
                <div x-data="{
                    search: '',
                    users: {{ Illuminate\Support\Js::from($permission->users) }},
                    usersFiltered() {
                        if (! this.search.length) return this.users;

                        return this.users.filter(user => user.name.toLowerCase().includes(this.search.toLowerCase()) ? true : false)
                    }
                }">
                    <button
                        class="underline underline-offset-2 text-[#7F9CF5] text-xs dark:text-white font-medium"
                        @click="show = ! show; search = '';"
                        x-ref="button"
                        x-init="$watch('show', value => $nextTick(() => { if (value) $refs.search.focus() }))"
                    >
                        <span class="ml-2">+{{ $permission->users_count - 4 }}</span>
                    </button>

                    <div
                        x-show="show"
                        x-anchor.right-start.offset.5="$refs.button"
                        x-ref="menu"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        @click.outside="show = false"
                        @keyup.escape="show = false"
                        class="absolute max-w-72 w-full bg-white dark:bg-gray-800 border border-gray-200
                            dark:border-gray-700 rounded-md shadow-md z-50"
                    >
                        <div class="px-3 pt-3 mb-1">
                            <x-input x-ref="search" class="w-full" type="search" x-model="search" />
                        </div>

                        <div class="max-h-52 overflow-y-auto">
                            <template x-if="usersFiltered().length">
                                <p class="text-xs text-gray-400 px-3 mt-2 mb-1">
                                    <span x-text="usersFiltered().length"></span>
                                    usuario(s)
                                </p>
                            </template>

                            <ul>
                                <template x-for="user in usersFiltered()" :key="user.id">
                                    <li class="flex items-center px-5 py-1.5 overflow-x-hidden">
                                        <a :href="'/admin/users/' + user.id">
                                            <img class="w-7 h-7 rounded-full" :src="user.profile_photo_url" :alt="user.name" />
                                        </a>

                                        <p x-text="user.name" class="ml-2 truncate text-gray-600 dark:text-gray-300"></p>
                                    </li>
                                </template>

                                <template x-if="! usersFiltered().length">
                                    <li class="text-gray-400 italic text-xs text-center py-3">
                                        No hay coincidencias con su búsqueda.
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </td>

    <td class="px-4 py-4 text-sm whitespace-nowrap">
        <div x-data="{ show: false }" class="flex flex-col items-start text-gray-600 dark:text-gray-400">
            @forelse ($permission->roles->take(1) as $role)
                <p>
                    {{ App\Enums\RoleEnum::options()[$role->name] }}
                </p>
            @empty
                <span class="italic text-xs">Sin roles</span>
            @endforelse
            @if ($permission->roles_count > 1)
                <div x-data="{
                    search: '',
                    roles: {{ Illuminate\Support\Js::from($permission->roles) }},
                    rolesFiltered() {
                        if (! this.search.length) return this.roles;

                        return this.roles.filter(role => role.name.toLowerCase().includes(this.search.toLowerCase()) ? true : false)
                    }
                }">
                    <button
                        class="underline underline-offset-2 text-[#7F9CF5] text-xs dark:text-white font-medium"
                        @click="show = ! show; search = '';"
                        x-ref="button"
                        x-init="$watch('show', value => $nextTick(() => { if (value) $refs.search.focus() }))"
                    >
                        {{ $permission->roles_count - 1 }} más
                    </button>
                    <div
                        x-show="show"
                        x-anchor.bottom.offset.5="$refs.button"
                        x-ref="menu"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        @click.outside="show = false"
                        @keyup.escape="show = false"
                        class="absolute max-w-72 w-full bg-white dark:bg-gray-800 border border-gray-200
                            dark:border-gray-700 rounded-md shadow-md z-50 text-left text-sm"
                    >
                        <div class="px-3 pt-3">
                            <x-input x-ref="search" class="w-full" type="search" x-model="search" />
                        </div>

                        <div class="max-h-52 overflow-y-auto">
                            <template x-if="rolesFiltered().length">
                                <p class="text-xs text-gray-400 px-3 mt-2 mb-1">
                                    <span x-text="rolesFiltered().length"></span>
                                    roles(s)
                                </p>
                            </template>

                            <ul>
                                <template x-for="role in rolesFiltered()" :key="role.id">
                                    <li x-text="role.name" class="px-5 py-1.5 truncate text-gray-600 dark:text-gray-300 first-letter:uppercase"></li>
                                </template>

                                <template x-if="roles.length && ! rolesFiltered().length && search.length">
                                    <li class="text-gray-400 italic text-xs text-center py-3">
                                        No hay coincidencias con su búsqueda.
                                    </li>
                                </template>

                                <template x-if="! roles.length">
                                    <li class="text-gray-400 italic text-xs text-center py-3">
                                        No hay roles asignados.
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </td>

    <td class="px-4 py-4 text-sm whitespace-nowrap">
        <div class="flex gap-2 justify-center items-center">
            <div x-data="{ show: false }">
                <button
                    class="p-2 rounded-md"
                    :class="$store.darkMode.on ? 'bg-gray-700' : 'bg-gray-100'"
                    @click="show = ! show"
                    @keyup.escape="show = false"
                    x-ref="button"
                >
                    <svg
                        class="icon icon-tabler icon-tabler-dots-vertical w-5 h-5 text-gray-500"
                        :class="$store.darkMode.on ? 'text-white hover:text-gray-300' : 'text-gray-600 hover:text-gray-900'"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                    </svg>
                </button>

                <div
                    x-show="show"
                    x-anchor.left-start.offset.5="$refs.button"
                    x-ref="menu"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    @click.outside="show = false"
                    class="absolute py-1 max-w-48 w-full bg-white dark:bg-gray-800 border border-gray-200
                        dark:border-gray-700 rounded-md shadow-md z-50"
                >
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        Opciones
                    </div>

                    <button
                        class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100
                            dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out"
                        wire:click="setPermission('{{ $permission->id }}')"
                        @click="$dispatch('set-edit-description-{{ $permission->id }}'); show = false;"
                    >
                        <svg
                            class="icon icon-tabler icon-tabler-edit inline-flex w-5 h-5 text-gray-500 mr-2"
                            :class="$store.darkMode.on ? 'text-white hover:text-gray-300' : 'text-gray-600 hover:text-gray-900'"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" />
                        </svg>
                        Editar descripción
                    </button>
                </div>

                <div
                    x-data="{ show: false, isLoading: false }"
                    x-init="
                        $wire.on('show-edit-description-{{ $permission->id }}', () => { isLoading = false; $nextTick(() => { $refs.description.focus() }) })
                        $wire.on('close-edit-description-{{ $permission->id }}', () => { show = false; })
                        $watch('show', value => { if (value) isLoading = true })
                    "
                    @set-edit-description-{{ $permission->id }}.window="show = true"
                >
                    <div
                        x-show="show"
                        x-anchor.left-start.offset.5="$refs.button"
                        x-ref="menu"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        @click.outside="show = false"
                        @keyup.escape="show = false"
                        class="absolute max-w-96 w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-md shadow-md"
                    >
                        <form wire:submit="saveDescription">
                            <h3 class="inline-flex items-center text-gray-700 dark:text-white text-base font-medium px-6 py-4">
                                <svg class="icon icon-tabler icon-tabler-edit w-5 h-5 mr-2" :class="$store.darkMode.on ? 'text-white hover:text-gray-300' : 'text-gray-600 hover:text-gray-900'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                Editar Descripción
                            </h3>

                            <hr class="mb-4 dark:border-gray-700">

                            <template x-if="! isLoading">
                                <div class="px-4 py-2">
                                    <textarea
                                        class="w-full border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500
                                            dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                        rows="5"
                                        wire:model="description"
                                        x-ref="description"
                                    ></textarea>

                                    <p class="text-xs text-gray-600 dark:text-gray-300" :class="$wire.description.length > 180 ? 'text-red-600 dark:text-red-300' : ''">
                                        <span x-text="$wire.description.length"></span>
                                        <span>/ 180</span>
                                    </p>

                                    <div class="flex justify-end gap-4 mt-4">
                                        <x-default-button
                                            class="btn-sm"
                                            @click="show = false"
                                        >cancelar</x-default-button>

                                        <x-primary-button
                                            class="btn-sm"
                                        >guardar</x-primary-button>
                                    </div>
                                </div>
                            </template>

                            <template x-if="isLoading">
                                <div class="flex justify-center items-center gap-2 mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-loader animate-spin dark:text-white" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 6l0 -3" /><path d="M16.25 7.75l2.15 -2.15" /><path d="M18 12l3 0" /><path d="M16.25 16.25l2.15 2.15" /><path d="M12 18l0 3" /><path d="M7.75 16.25l-2.15 2.15" /><path d="M6 12l-3 0" /><path d="M7.75 7.75l-2.15 -2.15" /></svg>
                                </div>
                            </template>
                        </form>
                    </div>
                </div>
            </div>

            <a
                class="p-2 rounded-md"
                :class="$store.darkMode.on ? 'bg-gray-700' : 'bg-gray-100'"
                x-tooltip.raw="Ver"
                href="#"
            >
                <svg
                    class="icon icon-tabler icon-tabler-eye-up w-5 h-5 text-gray-500"
                    :class="$store.darkMode.on ? 'text-white hover:text-gray-300' : 'text-gray-600 hover:text-gray-900'"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M12 18c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6c-.09 .15 -.18 .295 -.27 .439" /><path d="M19 22v-6" /><path d="M22 19l-3 -3l-3 3" />
                </svg>
            </a>
        </div>
    </td>
</tr>
