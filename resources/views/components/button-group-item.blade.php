@props(['selected' => false])

@php
    $selectionClasses = $selected ? 'bg-gray-100 dark:bg-gray-900' : 'bg-white';
@endphp

<button
    class="px-5 py-2 text-xs font-medium text-gray-600 sm:text-sm dark:bg-gray-800
        dark:hover:bg-gray-700 dark:text-white hover:bg-gray-100 {{ $selectionClasses }}"
    type="button"
    {{ $attributes }}
>
    {{ $slot }}
</button>
