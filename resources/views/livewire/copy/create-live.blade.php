<div class="max-w-7xl mx-auto lg:flex gap-4 px-4">
    <div class="lg:w-4/12 2xl:w-3/12"></div>

    <div class="lg:w-8/12 2xl:w-9/12">
        <x-form-card submit="save">
            <x-slot name="title">
                <h2 class="inline-flex items-center text-gray-700 dark:text-white font-medium text-lg">
                    <x-icons.add class="w-5 h-5 me-2" />

                    Nueva Copia
                </h2>
            </x-slot>

            <x-copies.form :$form />
        </x-form-card>
    </div>
</div>
