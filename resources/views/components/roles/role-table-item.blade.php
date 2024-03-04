<tr wire:key="{{ $role->id }}">
    <td class="max-w-0 sm:max-w-none px-4 py-4 text-sm font-medium whitespace-nowrap">
        <h2 class="font-medium text-gray-800 dark:text-white truncate">{{ App\Enums\RoleEnum::options()[$role->name] }}</h2>
        <dl class="lg:hidden">
            <dt class="sr-only"># Usuarios</dt>
            <dd class="font-normal text-xs text-gray-600 dark:text-gray-400 truncate mt-1">
                @if ($role->users_count)
                    <a class="underline underline-offset-2" href="{{ route('admin.users.index', ['roles' => $role->name]) }}">
                        {{ $role->users_count }} Usuario(s)
                    </a>
                @else
                    <span class="italic">Sin usuarios</span>
                @endif
            </dd>
        </dl>
    </td>

    <td class="hidden lg:table-cell px-4 py-4 text-sm whitespace-nowrap">
        <div x-data="{ show: false }" class="flex items-center">
            @forelse ($role->users->take(4) as $user)
                <a
                    class="object-cover shrink-0 -mx-1.5 flex text-sm border-2 border-white dark:border-gray-600
                        rounded-full focus:outline-none focus:border-gray-300"
                    href="{{ route('admin.users.show', $user) }}"
                    wire:key="{{ $user->id }}"
                    wire:navigate
                >
                    <img class="w-6 h-6 rounded-full" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" />
                </a>
            @empty
                <span class="italic text-xs text-gray-600 dark:text-gray-400">Sin usuarios</span>
            @endforelse

            @if ($role->users_count > 4)
                <div x-data="{
                    search: '',
                    users: {{ Illuminate\Support\Js::from($role->users) }},
                    get usersFiltered() {
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
                        <span class="ml-2">+{{ $role->users_count - 4 }}</span>
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
                        class="absolute max-w-72 w-full bg-white dark:bg-gray-700 rounded-md shadow-md z-50 border border-gray-200 dark:border-gray-600"
                    >
                        <div class="px-3 pt-3 mb-1">
                            <x-input x-ref="search" class="w-full" type="search" x-model="search" />
                        </div>

                        <div class="max-h-52 overflow-y-auto">
                            <template x-if="usersFiltered.length">
                                <p class="text-xs text-gray-400 px-3 mt-2 mb-1">
                                    <span x-text="usersFiltered.length"></span>
                                    usuario(s)
                                </p>
                            </template>

                            <ul>
                                <template x-for="user in usersFiltered" :key="user.id">
                                    <li class="flex items-center px-5 py-1.5 overflow-x-hidden">
                                        <a :href="'/admin/users/' + user.id" wire:navigate>
                                            <img class="w-7 h-7 rounded-full" :src="user.profile_photo_url" :alt="user.name" />
                                        </a>

                                        <p x-text="user.name" class="ml-2 truncate text-gray-600 dark:text-gray-300"></p>
                                    </li>
                                </template>

                                <template x-if="! usersFiltered.length">
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
        <div
            class="flex flex-col items-center md:items-start"
            x-data="{
                show: false,
                search: '',
                permissions: {{ Illuminate\Support\Js::from($role->permissions) }},
                get permissionsFiltered() {
                    if (! this.search.length) return this.permissions

                    return this.permissions.filter(permission => permission.name.toLowerCase().includes(this.search.toLowerCase()) ? true : false)
                },
            }"
        >
            <div class="w-full sm:w-48 text-xs text-center">
                <div class="h-1.5 relative rounded-full overflow-hidden">
                    <div class="w-full h-full bg-blue-200 absolute"></div>
                    <div
                        class="h-full bg-blue-500 absolute"
                        style="width: {{ ($role->permissions_count / $this->permissionsCount) * 100 }}%"
                    ></div>
                </div>
                <button
                    class="mt-1 underline underline-offset-2 text-[#7F9CF5] text-xs dark:text-white font-medium"
                    @click="show = ! show; search = '';"
                    x-ref="button"
                    x-init="$watch('show', value => $nextTick(() => { if (value) $refs.search.focus() }))"
                >
                    {{ $role->permissions_count }} / {{ $this->permissionsCount }}
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
                    class="absolute max-w-72 w-full bg-white dark:bg-gray-700 rounded-md shadow-md z-50 text-left text-sm
                        border border-gray-200 dark:border-gray-600"
                >
                    <div class="px-3 pt-3">
                        <x-input x-ref="search" class="w-full" type="search" x-model="search" />
                    </div>

                    <div class="max-h-52 overflow-y-auto">
                        <template x-if="permissionsFiltered.length">
                            <p class="text-xs text-gray-400 px-3 mt-2 mb-1">
                                <span x-text="permissionsFiltered.length"></span>
                                permiso(s)
                            </p>
                        </template>

                        <ul>
                            <template x-for="permission in permissionsFiltered" :key="permission.id">
                                <li x-text="permission.name" class="px-5 py-1.5 truncate text-gray-600 dark:text-gray-300 first-letter:uppercase"></li>
                            </template>

                            <template x-if="permissions.length && ! permissionsFiltered.length && search.length">
                                <li class="text-gray-400 italic text-xs text-center py-3">
                                    No hay coincidencias con su búsqueda.
                                </li>
                            </template>

                            <template x-if="! permissions.length">
                                <li class="text-gray-400 italic text-xs text-center py-3">
                                    No hay permisos asignados.
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </td>

    <td class="px-4 py-4 text-sm whitespace-nowrap">
        <div class="flex justify-center items-center gap-2">
            <div x-data="{ show: false }">
                <button
                    class="p-2 rounded-md bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-600 hover:text-gray-900
                    dark:text-white dark:hover:text-gray-300 border border-gray-200 dark:border-gray-600 shadow"
                    @click="show = ! show"
                    @keyup.escape="show = false"
                    x-tooltip.raw="Opciones"
                    x-ref="button"
                >
                    <svg class="icon icon-tabler icon-tabler-dots-vertical w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /></svg>
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
                    class="absolute py-1 max-w-48 w-full bg-white dark:bg-gray-700 rounded-md shadow-md z-50 border border-gray-200 dark:border-gray-600"
                >
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        Opciones
                    </div>

                    <a
                        href="{{ route('admin.roles.permissions.assignment', $role) }}"
                        class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-600 transition duration-150 ease-in-out"
                        @click="show = false"
                        wire:navigate
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-up inline-flex w-5 h-5 mr-2" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4" /><path d="M19 22v-6" /><path d="M22 19l-3 -3l-3 3" /></svg>
                        Asignar permisos
                    </a>
                </div>
            </div>

            <a
                class="p-2 rounded-md bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-600 hover:text-gray-900
                dark:text-white dark:hover:text-gray-300 border border-gray-200 dark:border-gray-600 shadow"
                href="{{ route('admin.roles.show', $role) }}"
                x-tooltip.raw="Ver"
                wire:navigate
            >
                <svg class="icon icon-tabler icon-tabler-eye-up w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M12 18c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6c-.09 .15 -.18 .295 -.27 .439" /><path d="M19 22v-6" /><path d="M22 19l-3 -3l-3 3" /></svg>
            </a>
        </div>
    </td>
</tr>
