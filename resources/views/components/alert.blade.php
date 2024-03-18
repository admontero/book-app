<div
    class="sticky top-4 left-0 z-50"
    x-persist="alert"
>
    <div
        class="absolute right-0 sm:px-4 max-w-[45rem] w-full"
        x-data="{
            alerts: [],
            remove(id) { this.alerts = this.alerts.filter((alert) => alert.id != id) }
        }"
        @new-alert.window="alerts.push({ id: new Date().getTime() + alerts.length, ...$event.detail })"
    >
        <template x-for="alert in alerts" :key="alert.id">
            <div
                class="w-full shadow flex items-center mb-2 p-4 border-t-4"
                role="alert"
                x-data="{ shown: false }"
                x-bind="container(alert?.type)"
                x-init="
                    $nextTick(() => shown = true );
                    setTimeout(() => { shown = false }, 5000)
                "
                x-show="shown"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="translate-x-96"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-96"
                x-on:transitionend="if (! shown) remove(alert.id)"
            >
                <svg class="flex-shrink-0 w-4 h-4" :class="alert?.type == 'dark' && 'dark:text-gray-300'" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>

                <div class="ms-3 text-sm font-medium" :class="alert?.type == 'dark' && 'text-gray-800 dark:text-gray-300'" x-text="alert?.message"></div>

                <button @click="shown = false" x-bind="button(alert?.type)" type="button" class="ms-auto -mx-1.5 -my-1.5 rounded-lg focus:ring-2 p-1.5 inline-flex items-center justify-center h-8 w-8" aria-label="Close">
                    <span class="sr-only">Dismiss</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        </template>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        document.addEventListener('alpine:init', () => {
            Alpine.bind('container', (type = '') => ({
                ':class'() {
                    let styles = {
                        'info': 'text-blue-800 border-blue-300 bg-blue-50 dark:text-blue-400 dark:bg-gray-800 dark:border-blue-800',
                        'danger': 'text-red-800 border-red-300 bg-red-50 dark:text-red-400 dark:bg-gray-800 dark:border-red-800',
                        'success': 'text-green-800 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800',
                        'warning': 'text-yellow-800 border-yellow-300 bg-yellow-50 dark:text-yellow-300 dark:bg-gray-800 dark:border-yellow-800',
                        'dark': 'border-gray-300 bg-gray-50 dark:bg-gray-800 dark:border-gray-600',
                    }

                    return type ? styles[type] : styles.info
                },
            }))

            Alpine.bind('button', (type = '') => ({
                ':class'() {
                    let styles = {
                        'info': 'bg-blue-50 text-blue-500 focus:ring-blue-400 hover:bg-blue-200 dark:bg-gray-800 dark:text-blue-400 dark:hover:bg-gray-700',
                        'danger': 'bg-red-50 text-red-500 focus:ring-red-400 hover:bg-red-200 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700',
                        'success': 'bg-green-50 text-green-500 focus:ring-green-400 hover:bg-green-200 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700',
                        'warning': 'bg-yellow-50 text-yellow-500 focus:ring-yellow-400 hover:bg-yellow-200 dark:bg-gray-800 dark:text-yellow-300 dark:hover:bg-gray-700',
                        'dark': 'bg-gray-50 text-gray-500 focus:ring-gray-400 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white',
                    }

                    return type ? styles[type] : styles.info
                },
            }))
        });
    </script>
@endpush
