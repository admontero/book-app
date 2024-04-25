<div>
    <div class="relative">
        <x-label value="Edición" />

        <x-custom-select
            containerClass="w-full lg:w-3/4"
            :config="[
                'items' => 'form.editions',
                'value' => 'form.edition_id',
                'element' => 'edition_list',
                'placeholder' => 'Selecciona la edición',
                'empty' => 'No hay ediciones disponibles.'
            ]"
            :listeners="[
                'update' => '
                    if (! $event.detail.value) return resetValue();

                    $wire.form.edition_id = $event.detail.value
                ',
            ]"
        />

        <x-input-error for="form.edition_id" />
    </div>

    <div class="mt-4">
        <x-label value="ID" />

        <x-input
            class="w-full lg:w-3/4 mt-1"
            wire:model="form.identifier"
        />

        <x-input-error for="form.identifier" />
    </div>

    <div class="mt-4">
        <x-label value="Estado" />

        <select
            class="w-full lg:w-3/4 mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500
                dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
            wire:model.change="form.status"
        >
            @foreach (App\Enums\CopyStatusEnum::options() as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
        </select>

        <x-input-error for="form.status" />
    </div>

    @if (! $form->is_retired)
        <div class="mt-8">
            <label class="inline-flex items-center cursor-pointer">
                <input
                    class="sr-only peer"
                    type="checkbox"
                    wire:model="form.is_loanable"
                />

                <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>

                <p class="ms-3 text-gray-700 dark:text-gray-300">
                    ¿Esta copia se puede prestar?
                </p>
            </label>

            <x-input-error for="form.is_loanable" />
        </div>
    @endif

    <hr class="my-4 -mx-6 dark:border-gray-700">

    <div class="flex justify-end gap-4">
        <a
            class="btn-sm flex items-center px-4 py-2 font-medium tracking-wide text-gray-600 capitalize
            transition-colors duration-300 transform bg-white rounded-lg hover:bg-gray-50 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80"
            href="{{ route('back.copies.index') }}"
            wire:navigate
        >cancelar</a>

        <x-primary-button
            class="btn-sm"
            type="submit"
        >Guardar</x-primary-button>
    </div>
</div>
