@props(['width' => 'w-48', 'position' => 'bottom', 'triggerClasses' => ''])

@php
    $positionValues = [
        'top', 'top-start', 'top-end', 'right', 'right-start', 'right-end', 'left', 'left-start', 'left-end', 'bottom', 'bottom-start', 'bottom-end'
    ];

    $position = in_array($position, $positionValues) ? $position : 'bottom';
@endphp

<div
    x-data="{ show: false }"
    @mousedown.outside="show = false"
    @close.stop="show = false"
    @keyup.escape="show = false"
    {{ $attributes->whereStartsWith('wire:ignore') }}
>
    <div x-on:click="show = ! show" x-ref="trigger" class="{{ $triggerClasses }}">
        {{ $trigger }}
    </div>

    <div
        class="absolute py-1 {{ $width }} bg-white dark:bg-gray-800 rounded-md shadow-md z-50 border border-gray-200 dark:border-gray-600"
        x-show="show"
        x-anchor.{{ $position }}.offset.5="$refs.trigger"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
    >
        {{ $content }}
    </div>
</div>
