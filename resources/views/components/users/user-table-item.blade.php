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
            <span class="italic">Sin rol</span>
        @endif
    </td>

    <td class="px-4 py-4 text-sm whitespace-nowrap">
        <div class="flex flex-col items-center md:items-start">
            <div class="w-full sm:w-48 text-xs text-center">
                <div class="h-1.5 relative rounded-full overflow-hidden">
                    <div class="w-full h-full bg-blue-200 absolute"></div>
                    <div
                        class="h-full bg-blue-500 absolute"
                        style="width: {{ ($user->permissions_count / $this->permissionsCount) * 100 }}%"
                    ></div>
                </div>
                <p class="mt-1 dark:text-white">{{ $user->permissions_count }} / {{ $this->permissionsCount }}</p>
            </div>
        </div>
    </td>

    <td class="px-4 py-4 text-sm whitespace-nowrap">
        <div class="flex justify-center items-center">
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
        {{-- <x-dropdown-table>
            <x-slot name="trigger">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-dots-vertical cursor-pointer w-5 h-5 text-gray-400 dark:text-gray-600" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /></svg>
            </x-slot>

            <x-slot name="content">
                <div class="block px-4 py-2 text-xs text-gray-400">
                    Acciones
                </div>
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                    <li>
                        <button
                            class="inline-flex items-center w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100
                                dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out"
                            wire:click="$dispatch('show-assign-permission-modal-{{ $user->id }}')"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-up w-5 h-5 mr-2" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4" /><path d="M19 22v-6" /><path d="M22 19l-3 -3l-3 3" /></svg>
                            Asignar Permisos
                        </button>
                    </li>
                </ul>
            </x-slot>
        </x-dropdown-table> --}}
    </td>

    {{-- <livewire:assign-permission-live
        :model="$user"
        :allPermissions="$allPermissions"
        wire:key="assign-permission-modal-{{ $user->id }}"
        @saved="$refresh"
    /> --}}
</tr>
