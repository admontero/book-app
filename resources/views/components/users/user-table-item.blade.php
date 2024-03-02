<tr wire:key="user-{{ $user->id }}">
    <td class="max-w-0 sm:max-w-none px-4 py-4 text-sm font-medium whitespace-nowrap">
        <h2 class="font-medium text-gray-800 dark:text-white truncate">{{ $user->name }}</h2>
        <dl class="xl:hidden">
            <dt class="sr-only">Email</dt>
            <dd class="font-normal text-gray-600 dark:text-gray-400 truncate">
                {{ $user->email }}
            </dd>
            <dt class="sr-only lg:hidden">Role</dt>
            <dd class="font-normal text-gray-600 dark:text-gray-400 truncate lg:hidden">
                @forelse ($user->roles as $role)
                    <span>
                        {{ App\Enums\RoleEnum::options()[$role->name] }}
                    </span>
                @empty
                    <span class="italic text-gray-600 dark:text-gray-400">Sin rol</span>
                @endforelse
            </dd>
        </dl>
    </td>

    <td class="hidden xl:table-cell px-4 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-400">
        {{ $user->email }}
    </td>

    <td class="hidden lg:table-cell px-4 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-400">
        @if ($user->roles->first())
            <span>{{ App\Enums\RoleEnum::options()[$user->roles->first()?->name] }}</span>
        @else
            <span class="italic text-xs">Sin rol</span>
        @endif
    </td>

    <td
        class="px-4 py-4 text-sm whitespace-nowrap"
        x-data="{
            show: false,
            search: '',
            directPermissions: {{ Illuminate\Support\Js::from($user->getDirectPermissions()) }},
            indirectPermissions: {{ Illuminate\Support\Js::from($user->getPermissionsViaRoles()) }},
            permissionsFiltered(permissions) {
                if (! this.search.length) return permissions

                return permissions.filter(permission => permission.name.toLowerCase().includes(this.search.toLowerCase()) ? true : false)
            },
        }"
    >
        <div class="flex flex-col items-center md:items-start">
            <div class="w-full sm:w-48 text-xs text-center">
                <div class="h-1.5 relative rounded-full overflow-hidden">
                    <div class="w-full h-full bg-blue-200 absolute"></div>
                    <div
                        class="h-full bg-blue-500 absolute"
                        style="width: {{ ($user->permissions_count / $this->permissionsCount) * 100 }}%"
                    ></div>
                </div>

                <button
                    class="mt-1 underline underline-offset-2 text-[#7F9CF5] text-xs dark:text-white font-medium"
                    @click="show = ! show; search = '';"
                    x-ref="button"
                    x-init="$watch('show', value => $nextTick(() => { if (value) $refs.search.focus() }))"
                >
                    {{ $user->permissions_count }} / {{ $this->permissionsCount }}
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
                        <template x-if="directPermissions.length">
                            <div>
                                <p class="text-xs text-gray-400 px-3 mt-2 mb-1">
                                    <span x-text="permissionsFiltered(directPermissions).length"></span>
                                    permiso(s) directo(s)
                                </p>
                                <ul>
                                    <template x-for="permission in permissionsFiltered(directPermissions)" :key="permission.id">
                                        <li x-text="permission.name" class="px-5 py-1.5 truncate text-gray-600 dark:text-gray-300 first-letter:uppercase"></li>
                                    </template>

                                    <template x-if="directPermissions.length && ! permissionsFiltered(directPermissions).length && search.length">
                                        <li class="text-gray-400 italic text-xs text-center py-3">
                                            No hay coincidencias con su búsqueda.
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </template>
                        <template x-if="indirectPermissions.length">
                            <div>
                                <p class="text-xs text-gray-400 px-3 mt-2 mb-1">
                                    <span x-text="permissionsFiltered(indirectPermissions).length"></span>
                                    permiso(s) indirecto(s)
                                </p>
                                <ul>
                                    <template x-for="permission in permissionsFiltered(indirectPermissions)" :key="permission.id">
                                        <li x-text="permission.name" class="px-5 py-1.5 truncate text-gray-600 dark:text-gray-300 first-letter:uppercase"></li>
                                    </template>

                                    <template x-if="indirectPermissions.length && ! permissionsFiltered(indirectPermissions).length && search.length">
                                        <li class="text-gray-400 italic text-xs text-center py-3">
                                            No hay coincidencias con su búsqueda.
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </template>
                        <template x-if="! directPermissions.length && ! indirectPermissions.length">
                            <p class="text-gray-400 italic text-xs text-center py-3">
                                No hay permisos asignados.
                            </p>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </td>

    <td class="px-4 py-4 text-sm whitespace-nowrap">
        <div class="flex justify-center gap-2 items-center">
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

                    <a
                        href="{{ route('admin.users.roles.assignment', $user) }}"
                        class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out"
                        @click="show = false"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-up inline-flex w-5 h-5 mr-2" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4" /><path d="M19 22v-6" /><path d="M22 19l-3 -3l-3 3" /></svg>
                        Asignar rol
                    </a>
                    <a
                        href="{{ route('admin.users.permissions.assignment', $user) }}"
                        class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out"
                        @click="show = false"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-up inline-flex w-5 h-5 mr-2" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4" /><path d="M19 22v-6" /><path d="M22 19l-3 -3l-3 3" /></svg>
                        Asignar permisos
                    </a>
                </div>
            </div>
            <a
                class="p-2 rounded-md"
                :class="$store.darkMode.on ? 'bg-gray-700' : 'bg-gray-100'"
                href="{{ route('admin.users.show', $user) }}"
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
