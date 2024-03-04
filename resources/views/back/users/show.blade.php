<x-app-layout>
    <div class="lg:flex gap-4 px-4">
        <div class="bg-white dark:bg-gray-800 rounded-md border border-gray-200 dark:border-gray-700 lg:w-4/12 2xl:w-3/12 px-6 py-4">
            <div class="flex items-center">
                <img class="h-10 w-10 rounded-full object-cover" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" />
                <div class="ml-3">
                    <h2 class="text-gray-600 dark:text-white">{{ $user->name }}</h2>
                    @if ($user->roles->first())
                        <p class="text-sm text-gray-400">
                            {{ App\Enums\RoleEnum::options()[$user->roles->first()->name] }}
                        </p>
                    @else
                        <p class="text-sm text-gray-400 italic">
                            Sin rol
                        </p>
                    @endif
                </div>
            </div>

            <hr class="my-4 -mx-6 dark:border-gray-700">

            <ul class="text-sm text-gray-700 dark:text-gray-200 space-y-3">
                <li>
                    <a
                        class="inline-flex items-center w-full text-start text-sm leading-5 focus:outline-none text-gray-700 dark:text-gray-300"
                        href="{{ route('admin.users.roles.assignment', $user) }}"
                        wire:navigate
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-up w-5 h-5 mr-2" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4" /><path d="M19 22v-6" /><path d="M22 19l-3 -3l-3 3" /></svg>
                        Asignar Rol
                    </a>
                </li>
                <li>
                    <a
                        class="inline-flex items-center w-full text-start text-sm leading-5 focus:outline-none text-gray-700 dark:text-gray-300"
                        href="{{ route('admin.users.permissions.assignment', $user) }}"
                        wire:navigate
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-up w-5 h-5 mr-2" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4" /><path d="M19 22v-6" /><path d="M22 19l-3 -3l-3 3" /></svg>
                        Asignar Permisos
                    </a>
                </li>
            </ul>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-md border border-gray-200 dark:border-gray-700 lg:w-8/12 2xl:w-9/12 h-20 mt-4 lg:mt-0">

        </div>
    </div>
</x-app-layout>
