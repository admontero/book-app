<div {{ $attributes->merge(['class' => 'flex flex-col']) }}>
    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-2 lg:-mx-4">
        <div class="inline-block min-w-full py-2 align-middle md:px-2 lg:px-4">
            <div class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    {{ $slot }}
                </table>
            </div>
        </div>
    </div>
</div>
