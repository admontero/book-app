<div class="my-4 px-2 md:px-6">
    <div class="max-w-7xl mx-auto lg:flex lg:items-start lg:gap-4">
        <div class="lg:w-4/12 2xl:w-3/12">
            <x-roles.card :$role />
        </div>

        <div class="lg:w-8/12 2xl:w-9/12 mt-4 lg:mt-0">
            <div class="bg-white dark:bg-gray-800 rounded-md border border-gray-200 dark:border-gray-700">
                <div class="px-4 py-3">
                    <h2 class="text-lg capitalize dark:text-gray-200">{{ $this->totalUsers }} Usuarios</h2>
                </div>

                <hr class="dark:border-gray-700">

                <div class="relative w-full px-4 mt-4">
                    <span class="absolute top-2.5">
                        <x-icons.search class="w-5 h-5 mx-3 text-gray-400 dark:text-gray-600" />
                    </span>

                    <x-input
                        class="pl-11 w-full"
                        type="search"
                        placeholder="Buscar usuario..."
                        wire:model.live.debounce.500ms="usersSearch"
                    />
                </div>

                @if ($this->totalUsers)
                    @forelse ($this->users as $user)
                        <div
                            class="flex items-center gap-4 cursor-pointer text-gray-700 hover:bg-blue-100 dark:hover:bg-blue-900 px-4 py-2 my-2"
                            @click="$el.querySelector('a').click()"
                            wire:key="user-{{ $user->id }}"
                        >
                            <img class="object-cover w-10 h-10 rounded-md" src="{{ $user->profile_photo_url }}" alt="foto de {{ $user->name }}">

                            <div>
                                <div class="text-sm md:text-base font-medium text-gray-700 dark:text-gray-300">
                                    <a href="{{ route('back.users.show', $user) }}" wire:navigate>{{ $user->name }}</a>
                                </div>

                                <div class="text-xs md:text-sm font-normal text-gray-500 dark:text-gray-400 tracking-wide">{{ $user->email }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="flex justify-center items-center p-4 text-sm text-gray-500">
                            <p class="italic">
                                No hay coincidencias con su búsqueda
                            </p>
                        </div>
                    @endforelse
                @else
                    <div class="flex justify-center items-center p-4 text-sm text-gray-500">
                        <p class="italic">
                            No hay usuarios para este rol
                        </p>
                    </div>
                @endif

                @if ($this->users->hasPages())
                    <div class="px-4 py-3">
                        {{ $this->users->links('vendor.livewire.custom') }}
                    </div>
                @endif
            </div>

            <div class="max-w-md bg-white dark:bg-gray-800 rounded-md border border-gray-200 dark:border-gray-700 mt-4">
                <div class="px-4 py-3">
                    <h2 class="text-lg capitalize dark:text-gray-200">{{ $this->totalPermissions }} Permisos</h2>
                </div>

                <hr class="dark:border-gray-700">

                <div class="relative w-full px-4 my-4">
                    <span class="absolute top-2.5">
                        <x-icons.search class="w-5 h-5 mx-3 text-gray-400 dark:text-gray-600" />
                    </span>

                    <x-input
                        class="pl-11 w-full"
                        type="search"
                        placeholder="Buscar permiso..."
                        wire:model.live.debounce.500ms="permissionsSearch"
                    />
                </div>

                <hr class="dark:border-gray-700">

                @if ($this->totalPermissions)
                    @forelse ($this->permissions as $permission)
                        <div
                            class="px-4 py-2 border-b dark:border-gray-700"
                            wire:key="user-{{ $user->id }}"
                        >
                            <div class="text-sm md:text-base text-gray-700 dark:text-gray-300">
                                {{  App\Enums\PermissionEnum::options()[$permission->name] }}
                            </div>
                        </div>
                    @empty
                        <div class="flex justify-center items-center p-4 text-sm text-gray-500">
                            <p class="italic">
                                No hay coincidencias con su búsqueda
                            </p>
                        </div>
                    @endforelse
                @else
                    <div class="flex justify-center items-center p-4 text-sm text-gray-500">
                        <p class="italic">
                            No hay permisos para este rol
                        </p>
                    </div>
                @endif

                @if ($this->permissions->hasPages())
                    <div class="px-4 py-3">
                        {{ $this->permissions->links('vendor.livewire.custom') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
