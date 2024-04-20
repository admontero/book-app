@props(['disabled' => false])

<button
    {{ $attributes->merge(['type' => 'button', 'class' => 'btn-base font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-lg
        enabled:hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:enabled:hover:bg-blue-700 dark:focus:ring-blue-800
        tracking-wide disabled:opacity-75 disabled:cursor-not-allowed']) }}
    {{ $disabled ? 'disabled' : '' }}
>
    {{ $slot }}
</button>
