@props(['disabled' => false, 'label' => null, 'for'])

<div class="relative z-0 w-full group">
    <input
        {{ $disabled ? 'disabled' : '' }}
        name="{{ $for }}"
        id="{{ $for }}"
        placeholder=""
        {{ $attributes->merge(['class' => 'block rounded-t-lg px-2.5 pb-1.5 pt-4 text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer']) }}
    />

    <label for="{{ $for }}" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-3 scale-75 top-3 z-10
        origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0
        peer-focus:scale-75 peer-focus:-translate-y-3 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto"
    >
        Nombre
    </label>
</div>
