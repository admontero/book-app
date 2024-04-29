<div class="bg-white dark:bg-gray-800 overflow-hidden rounded-md border border-gray-200 dark:border-gray-700">
    <div class="px-4 py-3">
        <h2 class="text-lg text-center capitalize dark:text-gray-200">{{ App\Enums\RoleEnum::options()[$role->name] }}</h2>

        <p class="text-sm text-center text-gray-400">
            ROL
        </p>
    </div>

    <hr class="dark:border-gray-700">

    <ul class="text-sm text-gray-700 dark:text-gray-200 divide-y dark:divide-gray-700">
        <li>
            <a
                class="px-4 py-3 block w-full text-start text-sm leading-5 dark:text-gray-300 border-l-2 focus:outline-none
                    @if(request()->routeIs('back.roles.permissions.assignment')) border-blue-600 @else border-transparent @endif
                "
                href="{{ route('back.roles.permissions.assignment', $role) }}"
                wire:navigate
            >
                <x-icons.permission class="inline-flex w-5 h-5 me-2" />
                Asignar Permisos
            </a>
        </li>
    </ul>
</div>
