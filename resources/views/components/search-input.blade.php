@props(['placeholder' => ''])

<div {{ $attributes->merge(['class' => 'relative']) }}>
    <span class="absolute top-2.5">
        <x-icons.search class="w-5 h-5 mx-3 text-gray-400 dark:text-gray-500" />
    </span>

    <x-input
        class="pl-11 w-full"
        type="search"
        placeholder="{{ $placeholder }}"
        {{ $attributes->whereStartsWith('wire') }}
    />
</div>
