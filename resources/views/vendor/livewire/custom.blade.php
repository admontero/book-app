@php
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
@endphp

<div>
    @if ($paginator->hasPages())
        <div class="mt-6 sm:flex sm:items-center sm:justify-between">
            <div class="text-sm text-gray-500 dark:text-gray-400">
                Página
                <span class="font-medium text-gray-700 dark:text-gray-100">{{ $paginator->currentPage() }}</span>
                de
                <span class="font-medium text-gray-700 dark:text-gray-100">{{ $paginator->lastPage() }}</span>
            </div>

            <div class="flex items-center mt-4 gap-x-4 sm:mt-0">

                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <p class="flex items-center justify-center w-1/2 px-5 py-2 text-sm text-gray-700 capitalize bg-gray-100 border rounded-md sm:w-auto gap-x-2 dark:bg-gray-900 dark:text-gray-200 dark:border-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 rtl:-scale-x-100">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
                        </svg>

                        <span>
                            anterior
                        </span>
                    </p>
                @else
                    <button
                        class="flex items-center justify-center w-1/2 px-5 py-2 text-sm text-gray-700 capitalize bg-white border rounded-md sm:w-auto gap-x-2
                            hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-700"
                        type="button"
                        wire:click="previousPage('{{ $paginator->getPageName() }}')"
                        x-on:click="{{ $scrollIntoViewJsSnippet }}"
                        wire:loading.attr="disabled"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 rtl:-scale-x-100">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
                        </svg>

                        <span>
                            anterior
                        </span>
                    </button>
                @endif

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <button
                        class="flex items-center justify-center w-1/2 px-5 py-2 text-sm text-gray-700 capitalize bg-white border rounded-md sm:w-auto gap-x-2
                            hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-700"
                        type="button"
                        wire:click="nextPage('{{ $paginator->getPageName() }}')"
                        x-on:click="{{ $scrollIntoViewJsSnippet }}"
                        wire:loading.attr="disabled"
                    >
                        <span>
                            siguiente
                        </span>

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 rtl:-scale-x-100">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                        </svg>
                    </button>
                @else
                    <p class="flex items-center justify-center w-1/2 px-5 py-2 text-sm text-gray-700 capitalize bg-gray-100 border rounded-md sm:w-auto gap-x-2 dark:bg-gray-900 dark:text-gray-200 dark:border-gray-700">
                        <span>
                            siguiente
                        </span>

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 rtl:-scale-x-100">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                        </svg>
                    </p>
                @endif
            </div>
        </div>
    @endif
</div>
