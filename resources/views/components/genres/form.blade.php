<form wire:submit.prevent="{{ $method }}">
    <div class="px-4 py-5">
        <x-label value="Nombre" />

        <x-input
            class="w-full mt-1"
            wire:model="form.name"
            x-ref="name"
        />

        <x-input-error for="form.name" />
    </div>

    <div class="flex justify-end gap-4 px-4 py-2">
        <x-default-button
            class="btn-sm"
            @click="show = false;"
        >cancelar</x-default-button>

        <x-primary-button
            class="btn-sm"
        >guardar</x-primary-button>
    </div>
</form>
