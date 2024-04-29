<div class="my-4 px-2 md:px-6">
    <div class="max-w-7xl mx-auto lg:flex lg:items-start lg:gap-4">
        <div class="lg:w-4/12 2xl:w-3/12">
            <x-roles.card :$role />
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-md border border-gray-200 dark:border-gray-700 px-6 py-4 lg:w-8/12 2xl:w-9/12 mt-4 lg:mt-0">
            <form wire:submit="save">
                <h2 class="inline-flex items-center text-gray-700 dark:text-white font-medium text-lg">
                   <x-icons.permission class="w-5 h-5 me-2" />
                    Asignación de permisos
                </h2>

                <hr class="my-4 -mx-6 dark:border-gray-700">

                <div
                    x-data="{ permissions: @entangle('permissions'), allPermissionIds: {{ Illuminate\Support\Js::from($allPermissionIds) }}, selectedAll: @entangle('selectedAll') }"
                    x-init="
                        $watch('permissions', (value) => {
                            if (value.length !== allPermissionIds.length && selectedAll) $wire.setSwitch(false)
                            if (value.length === allPermissionIds.length && ! selectedAll) $wire.setSwitch(true)
                        })
                    "
                >
                    <div>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model.change="selectedAll" class="sr-only peer">
                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            <span class="ms-3 text-gray-700 dark:text-gray-300">
                                Asignar todos
                            </span>
                        </label>
                    </div>

                    <hr class="my-4 -mx-6 dark:border-gray-700">

                    <div class="space-y-4 sm:space-y-0 sm:grid grid-cols-2 gap-x-2 gap-y-4">
                        @foreach ($allPermissions as $permission)
                            <div wire:key="permission-checkbox-{{ $role->id }}-{{ $permission->id }}">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model="permissions" value="{{ $permission->id }}" class="sr-only peer">
                                    <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                    <p class="ms-3 text-gray-700 dark:text-gray-300">
                                        {{ App\Enums\PermissionEnum::options()[$permission->name] }}
                                    </p>
                                </label>
                                <p class="block text-sm text-gray-500 dark:text-gray-300">
                                    {{ $permission->description }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <hr class="my-4 -mx-6 dark:border-gray-700">

                <div class="flex justify-end gap-4">
                    <a
                        class="btn-sm flex items-center px-4 py-2 font-medium tracking-wide text-gray-600 capitalize
                        transition-colors duration-300 transform bg-white rounded-lg hover:bg-gray-50 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80"
                        href="{{ route('back.roles.show', $role) }}"
                        wire:navigate
                    >cancelar</a>

                    <x-primary-button
                        class="btn-sm"
                        type="submit"
                    >Guardar</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</div>
