<tr wire:key="{{ $role->id }}">
    <td class="max-w-0 sm:max-w-none px-4 py-4 text-sm font-medium whitespace-nowrap">
        <h2 class="font-medium text-gray-800 dark:text-white truncate">{{ App\Enums\RoleEnum::options()[$role->name] }}</h2>
        <dl class="lg:hidden">
            <dt class="sr-only"># Usuarios</dt>
            <dd class="font-normal text-xs text-gray-600 dark:text-gray-400 truncate mt-1">
                @if ($role->users_count)
                    <a class="underline underline-offset-2" href="{{ route('admin.users.index', ['roles' => $role->name]) }}">
                        {{ $role->users_count }} Usuario(s)
                    </a>
                @else
                    <span class="italic">Sin usuarios</span>
                @endif
            </dd>
        </dl>
    </td>

    <td class="hidden lg:table-cell px-4 py-4 text-sm whitespace-nowrap">
        <div class="flex items-center">
            @forelse ($role->users->take(4) as $user)
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

            @if ($role->users_count > 4)
                <a
                    class="underline text-[#7F9CF5] text-xs dark:text-white font-medium"
                    href="{{ route('admin.users.index', ['roles' => $role->name]) }}"
                >
                    <span class="ml-2">+{{ $role->users_count - 4 }}</span>
                </a>
            @endif
        </div>
    </td>

    <td class="px-4 py-4 text-sm whitespace-nowrap">
        <div class="flex flex-col items-center md:items-start">
            <div class="w-full sm:w-48 text-xs text-center">
                <div class="h-1.5 relative rounded-full overflow-hidden">
                    <div class="w-full h-full bg-blue-200 absolute"></div>
                    <div
                        class="h-full bg-blue-500 absolute"
                        style="width: {{ ($role->permissions_count / $this->permissionsCount) * 100 }}%"
                    ></div>
                </div>
                <p class="mt-1 dark:text-white">{{ $role->permissions_count }} / {{ $this->permissionsCount }}</p>
            </div>
        </div>
    </td>

    <td class="px-4 py-4 text-sm whitespace-nowrap">
        <div class="flex justify-center items-center">
            <a
                class="p-2 rounded-md"
                :class="$store.darkMode.on ? 'bg-gray-700' : 'bg-gray-100'"
                href="{{ route('admin.roles.show', $role) }}"
            >
                <svg
                    class="icon icon-tabler icon-tabler-eye-up w-5 h-5 text-gray-500"
                    :class="$store.darkMode.on ? 'text-white hover:text-gray-300' : 'text-gray-600 hover:text-gray-900'"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M12 18c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6c-.09 .15 -.18 .295 -.27 .439" /><path d="M19 22v-6" /><path d="M22 19l-3 -3l-3 3" />
                </svg>
            </a>
        </div>
    </td>
</tr>
