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
                    href="{{ route('back.users.show', $user) }}"
                    wire:key="{{ $user->id }}"
                    wire:navigate
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
                    get usersFiltered() {
                        if (! this.search.length) return this.users;

                        return this.users.filter(user => latinize(user.name.toLowerCase()).includes(latinize(this.search.toLowerCase())))
                    }
                }">
                    <x-dropdown-floating width="w-72">
                        <x-slot name="trigger">
                            <button
                                class="underline underline-offset-2 text-indigo-400 dark:text-indigo-300 text-xs font-medium"
                                x-init="$watch('show', value => $nextTick(() => { if (value) $refs.search.focus() }))"
                                @click="search = ''"
                            >
                                <span class="ml-2">+{{ $permission->users_count - 4 }}</span>
                            </button>
                        </x-slot>

                        <x-slot name="content">
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
                                            <a :href="'/back/users/' + user.id" wire:navigate>
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
                        </x-slot>
                    </x-dropdown-floating>
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
                    get rolesFiltered() {
                        if (! this.search.length) return this.roles;

                        return this.roles.filter(role => latinize(role.name.toLowerCase()).includes(latinize(this.search.toLowerCase())))
                    }
                }">
                    <x-dropdown-floating width="w-72">
                        <x-slot name="trigger">
                            <button
                                class="underline underline-offset-2 text-[#7F9CF5] text-xs dark:text-white font-medium"
                                x-init="$watch('show', value => $nextTick(() => { if (value) $refs.search.focus() }))"
                                @click="search = ''"
                            >
                                {{ $permission->roles_count - 1 }} más
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-3 pt-3">
                                <x-input x-ref="search" class="w-full" type="search" x-model="search" />
                            </div>

                            <div class="max-h-52 overflow-y-auto">
                                <template x-if="rolesFiltered.length">
                                    <p class="text-xs text-gray-400 px-3 mt-2 mb-1">
                                        <span x-text="rolesFiltered.length"></span>
                                        roles(s)
                                    </p>
                                </template>

                                <ul>
                                    <template x-for="role in rolesFiltered" :key="role.id">
                                        <li x-text="role.name" class="px-5 py-1.5 truncate text-gray-600 dark:text-gray-300 first-letter:uppercase"></li>
                                    </template>

                                    <template x-if="roles.length && ! rolesFiltered.length && search.length">
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
                        </x-slot>
                    </x-dropdown-floating>
                </div>
            @endif
        </div>
    </td>

    <td class="px-4 py-4 text-sm whitespace-nowrap">
        <div class="flex gap-2 justify-center items-center" x-ref="permission{{ $permission->id }}">
            <x-dropdown-floating position="left-start">
                <x-slot name="trigger">
                    <button
                        class="p-2 rounded-md bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-600 hover:text-gray-900
                        dark:text-white dark:hover:text-gray-300 border border-gray-200 dark:border-gray-600 shadow"
                        x-tooltip.raw="Opciones"
                    >
                        <x-icons.dots-vertical class="w-5 h-5" />
                    </button>
                </x-slot>

                <x-slot name="content">
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        Opciones
                    </div>

                    <button
                        class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100
                            dark:hover:bg-gray-600 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-600 transition duration-150 ease-in-out"
                        @click="$dispatch('set-edit-permission-{{ $permission->id }}'); show = false;"
                    >
                        <svg
                            class="icon icon-tabler icon-tabler-edit inline-flex w-5 h-5"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" />
                        </svg>
                        Editar descripción
                    </button>
                </x-slot>
            </x-dropdown-floating>

            <x-permissions.edit :$permission />

            <a
                class="p-2 rounded-md bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-600 hover:text-gray-900
                dark:text-white dark:hover:text-gray-300 border border-gray-200 dark:border-gray-600 shadow"
                x-tooltip.raw="Ver"
                href="#"
                wire:navigate
            >
                <x-icons.show class="w-5 h-5" />
            </a>
        </div>
    </td>
</tr>
