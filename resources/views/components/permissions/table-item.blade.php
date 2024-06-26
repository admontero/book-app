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
                                <div class="sticky top-0 text-sm font-medium text-gray-600 dark:text-gray-300 px-3 py-2 bg-white
                                    dark:bg-gray-800 border-b dark:border-gray-600"
                                >
                                    Usuarios
                                    (<span x-text="usersFiltered.length"></span>)
                                </div>

                                <ul>
                                    <template x-for="(user, i) in usersFiltered" :key="user.id">
                                        <li class="flex items-center px-5 py-1.5 overflow-x-hidden cursor-pointer text-gray-600 dark:text-gray-300
                                            hover:text-blue-600 dark:hover:text-blue-400"
                                            :class="i % 2 === 0 && 'bg-gray-50 dark:bg-gray-900'"
                                            @click="$el.querySelector('a').click()"
                                        >
                                            <a :href="'/back/users/' + user.id" wire:navigate>
                                                <img class="w-7 h-7 rounded-full" :src="user.profile_photo_url" :alt="user.name" />
                                            </a>

                                            <p x-text="user.name" class="ml-2 truncate"></p>
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
                            <div class="px-3 pt-3 mb-1">
                                <x-input x-ref="search" class="w-full" type="search" x-model="search" />
                            </div>

                            <div class="max-h-52 overflow-y-auto">
                                <div class="sticky top-0 text-sm font-medium text-gray-600 dark:text-gray-300 px-3 py-2 bg-white
                                    dark:bg-gray-800 border-b dark:border-gray-600"
                                >
                                    Roles
                                    (<span x-text="rolesFiltered.length"></span>)
                                </div>

                                <ul>
                                    <template x-for="(role, i) in rolesFiltered" :key="role.id">
                                        <li
                                            class="px-5 py-2 truncate text-gray-500 dark:text-gray-400 first-letter:uppercase"
                                            :class="i % 2 === 0 && 'bg-gray-50 dark:bg-gray-900'"
                                            x-text="role.name"
                                        ></li>
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
        <div class="flex gap-2 justify-center items-center">
            <div x-ref="permission_{{ $permission->id }}">
                <x-dropdown-floating position="left-start" wire:ignore>
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
                            class="flex w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100
                                dark:hover:bg-gray-600 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-600 transition duration-150 ease-in-out"
                            @click="$dispatch('show-modal-{{ $permission->id }}'); show = false;"
                        >
                            <x-icons.edit class="w-5 h-5 me-2" />
                            Editar descripción
                        </button>
                    </x-slot>
                </x-dropdown-floating>

                <livewire:permission.edit-live
                    :id="$permission->id"
                    wire:key="edit-modal-{{ $permission->id }}"
                    @saved="$refresh"
                />
            </div>

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
