<dl>
    <div class="px-4 py-3 bg-gray-50 dark:bg-gray-900 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
            Nombre
        </dt>

        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-3">
            {{ $user->name }}
        </dd>
    </div>

    <div class="px-4 py-3 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
            Email
        </dt>

        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-3">
            {{ $user->email }}
        </dd>
    </div>

    @if ($user?->profile?->document_type_id)
        <div class="px-4 py-3 bg-gray-50 dark:bg-gray-900 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Tipo Documento
            </dt>

            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-3">
                {{ $user?->profile?->document_type->name }}
                ({{ $user?->profile?->document_type->abbreviation }})
            </dd>
        </div>
    @endif

    @if ($user?->profile?->document_number)
        <div class="px-4 py-3 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Número Documento
            </dt>

            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-3">
                {{ $user?->profile?->document_number }}
            </dd>
        </div>
    @endif

    @if ($user?->profile?->phone)
        <div class="px-4 py-3 bg-gray-50 dark:bg-gray-900 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Teléfono
            </dt>

            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-3">
                {{ $user?->profile?->phone }}
            </dd>
        </div>
    @endif
</dl>
