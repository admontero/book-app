@props(['id' => null, 'maxWidth' => null, 'submit', 'contentClasses' => null])

@php
$id = $id ?? md5($attributes->wire('model'));

$maxWidth = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
    '3xl' => 'sm:max-w-3xl',
    '4xl' => 'sm:max-w-4xl',
    '5xl' => 'sm:max-w-5xl',
][$maxWidth ?? '2xl'];
@endphp

<div
    x-data="{ show: @entangle($attributes->wire('model')) }"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    x-show="show"
    id="{{ $id }}"
    class="z-50 overflow-auto inset-0 w-full h-full fixed py-6"
    style="display: none;"
>
    <div
        class="z-50 relative p-3 mx-auto my-0 {{ $maxWidth }}"
        x-show="show"
        x-trap.inert.noscroll="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    >
        <div class="bg-white rounded-lg shadow-lg border flex flex-col overflow-hidden dark:bg-gray-800 dark:border-gray-700">
            <div class="px-6 py-4 text-lg font-medium bg-gray-100 border border-gray-200 text-gray-900 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-700">
                {{ $title }}
            </div>

            <form wire:submit.prevent="{{ $submit }}">
                <div class="px-6 py-4 text-sm border-x border-gray-200 text-gray-600 dark:text-gray-400 dark:bg-gray-900 dark:border-gray-700 {{ $contentClasses }}">
                    {{ $content }}
                </div>

                <div class="flex flex-row justify-end px-6 py-4 bg-gray-100 border border-gray-200 dark:bg-gray-800 text-end dark:border dark:border-gray-700">
                    {{ $footer }}
                </div>
            </form>
        </div>
    </div>

    <div
        x-show="show"
        class="z-40 overflow-auto left-0 top-0 bottom-0 right-0 w-full h-full fixed bg-black opacity-50"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
    ></div>
</div>
