@props(['value', 'sortableFor' => null, 'sortField', 'sortDirection'])

<th
    {{ $attributes->merge(['class' => 'px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400']) }}
    scope="col"
>
    @if ($sortableFor)
        <button
            class="flex items-center gap-x-3 focus:outline-none @if ($sortField == $sortableFor) font-medium text-gray-800 dark:text-white @endif"
            type="button"
            wire:click="sortBy('{{ $sortableFor }}')"
        >
            <span>{{ $value }}</span>

            @if ($sortField == $sortableFor && $sortDirection === 'desc')
                <x-icons.sort-desc class="w-5 h-5" />
            @else
                <x-icons.sort-asc class="w-5 h-5" />
            @endif
        </button>

    @else
        <span>{{ $value }}</span>
    @endif
</th>
