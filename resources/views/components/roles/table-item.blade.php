<tr wire:key="{{ $role->id }}">
    <td class="max-w-0 sm:max-w-none px-4 py-4 text-sm font-medium whitespace-nowrap">
        <h2 class="font-medium text-gray-800 dark:text-white truncate">{{ App\Enums\RoleEnum::options()[$role->name] }}</h2>
        <dl class="lg:hidden">
            <dt class="sr-only"># Usuarios</dt>
            <dd class="font-normal text-xs text-gray-600 dark:text-gray-400 truncate mt-1">
                @if ($role->users_count)
                    <a
                        class="underline underline-offset-2 text-indigo-400 dark:text-indigo-300"
                        href="{{ route('back.users.index', ['roles' => $role->name]) }}"
                        wire:navigate
                    >
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
                    href="{{ route('back.users.show', $user) }}"
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

                        return this.users.filter(user => latinize(user.name.toLowerCase()).includes(latinize(this.search.toLowerCase())))
                    }
                }">

                    <x-dropdown-floating width="w-72">
                        <x-slot name="trigger">
                            <button
                                class="underline underline-offset-2 text-indigo-400 dark:text-indigo-300 text-xs font-medium"
                                x-init="$watch('show', value => $nextTick(() => { if (value) $refs.search.focus() }))"
                                @click="search = '';"
                            >
                                <span class="ml-2">+{{ $role->users_count - 4 }}</span>
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
                                        <li
                                            class="flex items-center px-5 py-1.5 overflow-x-hidden cursor-pointer text-gray-600 dark:text-gray-300
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
        <div
            class="flex flex-col items-center md:items-start"
            x-data="{
                show: false,
                search: '',
                permissions: {{ Illuminate\Support\Js::from($role->permissions) }},
                get permissionsFiltered() {
                    if (! this.search.length) return this.permissions

                    return this.permissions.filter(permission => latinize(permission.name.toLowerCase()).includes(latinize(this.search.toLowerCase())))
                },
            }"
        >
            <div class="w-full sm:w-48">
                <div class="h-1.5 relative rounded-full overflow-hidden">
                    <div class="w-full h-full bg-blue-200 absolute"></div>
                    <div
                        class="h-full bg-blue-500 absolute"
                        style="width: {{ ($role->permissions_count / $this->permissionsCount) * 100 }}%"
                    ></div>
                </div>

                <x-dropdown-floating width="w-72" triggerClasses="text-center">
                    <x-slot name="trigger">
                        <button
                            class="mt-1 underline underline-offset-2 text-indigo-400 dark:text-indigo-300 text-xs font-medium"
                            x-init="$watch('show', value => $nextTick(() => { if (value) $refs.search.focus() }))"
                            @click="search = ''"
                        >
                            {{ $role->permissions_count }} / {{ $this->permissionsCount }}
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
                                Permisos
                                (<span x-text="permissionsFiltered.length"></span>)
                            </div>

                            <ul>
                                <template x-for="(permission, i) in permissionsFiltered" :key="permission.id">
                                    <li
                                        class="px-5 py-2 truncate text-gray-500 dark:text-gray-400 first-letter:uppercase"
                                        :class="i % 2 === 0 && 'bg-gray-50 dark:bg-gray-900'"
                                        x-text="permission.name"
                                    ></li>
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
                    </x-slot>
                </x-dropdown-floating>
            </div>
        </div>
    </td>

    <td class="px-4 py-4 text-sm whitespace-nowrap">
        <div class="flex justify-center items-center gap-2">
            <x-dropdown-floating position="left-start" wire:ignore>
                <x-slot name="trigger">
                    <button
                        class="p-2 rounded-md bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-600 hover:text-gray-900
                        dark:text-white dark:hover:text-gray-300 border border-gray-200 dark:border-gray-600 focus:outline-none shadow"
                        x-tooltip.raw="Opciones"
                    >
                        <x-icons.dots-vertical class="w-5 h-5" />
                    </button>
                </x-slot>

                <x-slot name="content">
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        Opciones
                    </div>

                    <a
                        href="{{ route('back.roles.permissions.assignment', $role) }}"
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
                href="{{ route('back.roles.show', $role) }}"
                x-tooltip.raw="Ver"
                wire:navigate
            >
                <x-icons.show class="w-5 h-5" />
            </a>
        </div>
    </td>
</tr>
