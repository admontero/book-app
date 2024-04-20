<div>
    <h4 class="text-sm md:text-base mb-2 text-gray-700 dark:text-gray-400">Información del usuario seleccionado:</h4>

    <ul class="text-sm md:text-base ms-4 text-gray-700 dark:text-gray-400 dark:divide-gray-600">
        @if ($this->userSelected?->name)
            <li class="py-2 sm:flex sm:justify-between sm:gap-4">
                <p class="font-medium sm:w-48">
                    Nombre
                </p>
                <p class="sm:flex-1 capitalize">
                    {{ $this->userSelected?->name }}
                </p>
            </li>
        @endif

        @if ($this->userSelected?->email)
            <li class="py-2 sm:flex sm:justify-between sm:gap-4">
                <p class="font-medium sm:w-48">
                    Email
                </p>
                <p class="sm:flex-1">
                    {{ $this->userSelected?->email }}
                </p>
            </li>
        @endif

        @if ($this->userSelected?->profile?->document_type_id)
            <li class="py-2 sm:flex sm:justify-between sm:gap-4">
                <p class="font-medium sm:w-48">
                    Tipo Documento
                </p>
                <p class="sm:flex-1 capitalize">
                    {{ $this->userSelected?->profile?->document_type->name }}
                    ({{ $this->userSelected?->profile?->document_type->abbreviation }})
                </p>
            </li>
        @endif

        @if ($this->userSelected?->profile?->document_number)
            <li class="py-2 sm:flex sm:justify-between sm:gap-4">
                <p class="font-medium sm:w-48">
                    Número Documento
                </p>
                <p class="sm:flex-1 capitalize">
                    {{ number_format($this->userSelected?->profile?->document_number, 0, ',', '.') }}
                </p>
            </li>
        @endif

        @if ($this->userSelected?->profile?->phone)
            <li class="py-2 sm:flex sm:justify-between sm:gap-4">
                <p class="font-medium sm:w-48">
                    Teléfono
                </p>
                <p class="sm:flex-1 capitalize">
                    {{ $this->userSelected?->profile?->phone }}
                </p>
            </li>
        @endif
    </ul>
</div>
