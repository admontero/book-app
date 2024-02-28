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
        <div class="flex items-center">
            @forelse ($permission->users->take(4) as $user)
                <div
                    class="object-cover shrink-0 -mx-1.5 flex text-sm border-2 border-white dark:border-gray-600
                        rounded-full focus:outline-none focus:border-gray-300"
                    wire:key="{{ $user->id }}"
                >
                    <img class="w-6 h-6 rounded-full" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" />
                </div>
            @empty
                <span class="italic text-xs text-gray-600 dark:text-gray-400">Sin usuarios</span>
            @endforelse
            @if ($permission->users_count > 4)
                <span class="ml-2 text-xs text-[#7F9CF5] dark:text-gray-400 font-medium">+{{ $permission->users_count - 4 }}</span>
            @endif
        </div>
    </td>

    <td class="px-4 py-4 text-xs whitespace-nowrap">
        <div class="flex flex-col text-gray-600 dark:text-gray-400">
            @forelse ($permission->roles->take(2) as $role)
                <p class="">
                    {{ App\Enums\RoleEnum::options()[$role->name] }}
                </p>
            @empty
                <span class="italic text-xs">Sin roles</span>
            @endforelse
            @if ($permission->roles_count > 2)
                <span class="underline">{{ $permission->roles_count - 2 }} más</span>
            @endif
        </div>
    </td>

    <td class="px-4 py-4 text-sm whitespace-nowrap">
        <div class="flex gap-2 justify-center items-center">
            <div x-data="{ show: false, isLoading: false }">
                <button
                    type="button"
                    class="p-2 rounded-md"
                    :class="$store.darkMode.on ? 'bg-gray-700' : 'bg-gray-100'"
                    x-tooltip.raw="Editar Descripción"
                    wire:click="setPermission('{{ $permission->id }}')"
                    @click="show = ! show"
                    x-ref="button"
                    x-init="
                        $wire.on('show-edit-description-{{ $permission->id }}', () => { isLoading = false; $nextTick(() => { $refs.description.focus() }) })
                        $wire.on('close-edit-description-{{ $permission->id }}', () => { show = false; })
                        $watch('show', value => { if (value) isLoading = true })
                    "
                >
                    <svg
                        class="icon icon-tabler icon-tabler-edit w-5 h-5 text-gray-500"
                        :class="$store.darkMode.on ? 'text-white hover:text-gray-300' : 'text-gray-600 hover:text-gray-900'"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" />
                    </svg>
                </button>

                <div
                    wire:ignore.self
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

    {{-- <livewire:permission-description-edit-live
        :id="$permission->id"
        wire:model="description"
        wire:key="permission-edition"
    /> --}}
</tr>
