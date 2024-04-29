<div class="bg-white dark:bg-gray-800 overflow-hidden rounded-md border border-gray-200 dark:border-gray-700">
    <div class="px-4 py-3">
        <h2 class="text-lg text-center capitalize dark:text-gray-200">{{ $user->name }}</h2>

        @if ($user->roles->first())
            <p class="text-center text-sm text-gray-400">
                {{ App\Enums\RoleEnum::options()[$user->roles->first()->name] }}
            </p>
        @endif
    </div>

    <hr class="dark:border-gray-700">

    <ul class="text-sm text-gray-700 dark:text-gray-200 divide-y dark:divide-gray-700">
        <li>
            <a
                class="px-4 py-3 block w-full text-start text-sm leading-5 dark:text-gray-300 border-l-2 focus:outline-none
                    @if(request()->routeIs('back.users.roles.assignment')) border-blue-600 @else border-transparent @endif
                "
                href="{{ route('back.users.roles.assignment', $user) }}"
                wire:navigate
            >
                <x-icons.role class="inline-flex w-5 h-5 me-2" />
                Asignar Rol
            </a>
        </li>

        <li>
            <a
                class="px-4 py-3 block w-full text-start text-sm leading-5 dark:text-gray-300 border-l-2 focus:outline-none
                    @if(request()->routeIs('back.users.permissions.assignment')) border-blue-600 @else border-transparent @endif
                "
                href="{{ route('back.users.permissions.assignment', $user) }}"
                wire:navigate
            >
                <x-icons.permission class="inline-flex w-5 h-5 me-2" />
                Asignar Permisos
            </a>
        </li>
    </ul>
</div>
