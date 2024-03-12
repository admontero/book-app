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
            <div class="w-full sm:w-48 text-xs">
                <div class="h-1.5 relative rounded-full overflow-hidden">
                    <div class="w-full h-full bg-blue-200 absolute"></div>
                    <div
                        class="h-full bg-blue-500 absolute"
                        style="width: {{ ($user->permissions_count / $this->permissionsCount) * 100 }}%"
                    ></div>
                </div>

                <x-dropdown-floating width="w-72" triggerClasses="text-center">
                    <x-slot name="trigger">
                        <button
                            class="mt-1 underline underline-offset-2 text-[#7F9CF5] text-xs dark:text-white font-medium"
                            x-init="$watch('show', value => $nextTick(() => { if (value) $refs.search.focus() }))"
                            @click="search = ''"
                        >
                            {{ $user->permissions_count }} / {{ $this->permissionsCount }}
                        </button>
                    </x-slot>

                    <x-slot name="content">
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
                    </x-slot>
                </x-dropdown-floating>
            </div>
        </div>
    </td>

    <td class="px-4 py-4 text-sm whitespace-nowrap">
        <div class="flex justify-center gap-2 items-center">
            <x-dropdown-floating position="left-start">
                <x-slot name="trigger">
                    <button
                        class="p-2 rounded-md bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-600 hover:text-gray-900
                        dark:text-white dark:hover:text-gray-300 border border-gray-200 dark:border-gray-600 focus:outline-none shadow"
                        x-tooltip.raw="Opciones"
                    >
                        <svg class="icon icon-tabler icon-tabler-dots-vertical w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /></svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        Opciones
                    </div>

                    <a
                        href="{{ route('admin.users.roles.assignment', $user) }}"
                        class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-600 transition duration-150 ease-in-out"
                        @click="show = false"
                        wire:navigate
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-up inline-flex w-5 h-5 mr-2" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4" /><path d="M19 22v-6" /><path d="M22 19l-3 -3l-3 3" /></svg>
                        Asignar rol
                    </a>
                    <a
                        href="{{ route('admin.users.permissions.assignment', $user) }}"
                        class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-600 transition duration-150 ease-in-out"
                        @click="show = false"
                        wire:navigate
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-up inline-flex w-5 h-5 mr-2" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4" /><path d="M19 22v-6" /><path d="M22 19l-3 -3l-3 3" /></svg>
                        Asignar permisos
                    </a>
                </x-slot>
            </x-dropdown-floating>

            <a
                class="p-2 rounded-md bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-600 hover:text-gray-900
                dark:text-white dark:hover:text-gray-300 border border-gray-200 dark:border-gray-600 shadow"
                href="{{ route('admin.users.show', $user) }}"
                x-tooltip.raw="Ver"
                wire:navigate
            >
                <svg class="icon icon-tabler icon-tabler-eye-up w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M12 18c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6c-.09 .15 -.18 .295 -.27 .439" /><path d="M19 22v-6" /><path d="M22 19l-3 -3l-3 3" /></svg>
            </a>
        </div>
    </td>
</tr>
