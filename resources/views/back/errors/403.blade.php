<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-center space-y-3">
                    <div class="font-semibold text-9xl dark:text-white">
                        403
                    </div>

                    <p class="text-xl font-bold dark:text-white">
                        El usuario no tiene los permisos para acceder a esta página.
                    </p>

                    <p class="dark:text-gray-300">
                        Comuníquese con el administrador o vuelva a la página principal con el link de abajo.
                    </p>

                    <div>
                        <a
                            class="uppercase tracking-wider underline underline-offset-2 text-blue-600 hover:text-blue-700 dark:text-blue-300 dark:hover:text-blue-400
                                font-semibold transition-colors duration-150 ease-in-out"
                            href="{{ route('back.dashboard') }}"
                            wire:navigate
                        >inicio</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
