<div class="bg-white dark:bg-gray-800 rounded-md border border-gray-200 dark:border-gray-700 mt-4 lg:mt-0">
    @if (isset($title))
        <div>
            <div class="p-4">
                {{ $title }}
            </div>

            <hr class="dark:border-gray-700">
        </div>
    @endif

    <form wire:submit.prevent="{{ $submit }}">
        {{ $slot }}
    </form>
</div>

@script
    <script>
        document.addEventListener('livewire:navigate', () => {
            const submitBtn = document.querySelector('button[type="submit"]');

            if(submitBtn) submitBtn.setAttribute("disabled", "disabled")
        })

        document.addEventListener('livewire:navigating', () => {
            const submitBtn = document.querySelector('button[type="submit"]');

            if(submitBtn) submitBtn.removeAttribute("disabled")
        })
    </script>
@endscript
