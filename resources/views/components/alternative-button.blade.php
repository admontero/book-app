@props(['disabled' => false])

<button
    {{ $attributes->merge(['type' => 'button', 'class' => 'btn-base font-medium text-gray-900 focus:outline-none bg-white border border-gray-200
        rounded-lg enabled:hover:bg-gray-100 enabled:hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800
        dark:text-gray-400 dark:border-gray-600 dark:enabled:hover:text-white dark:enabled:hover:bg-gray-700 cursor-pointer tracking-wide
        disabled:opacity-75 disabled:cursor-not-allowed']) }}
    {{ $disabled ? 'disabled' : '' }}
>
    {{ $slot }}
</button>
