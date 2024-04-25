<div class="my-6 px-4">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-xl font-medium text-gray-800 dark:text-white">Registro de Préstamos</h2>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
            Sigue los pasos a continuación:
        </p>

        <div class="lg:flex lg:justify-center lg:gap-4 mt-6">
            <div class="w-full lg:w-72 px-12 py-4">
                <ol class="relative text-gray-500 border-s-2 border-gray-200 dark:border-gray-700 dark:text-gray-400">
                    <li class="mb-10 ms-8">
                        <span
                            class="absolute flex items-center justify-center w-10 h-10 rounded-full -start-[1.325rem] ring-2
                            @if($this->stepOneCompleted) bg-green-100 ring-green-200 dark:bg-green-700 dark:ring-green-900
                            @else bg-white ring-white dark:bg-gray-700 dark:ring-gray-900 @endif"
                        >
                            @if ($this->stepOneCompleted)
                                <x-icons.check class="w-5 h-5 text-green-500 dark:text-green-400" />
                            @else
                                <x-icons.id-card class="w-5 h-5 text-gray-500 dark:text-gray-400" />
                            @endif
                        </span>

                        <div class="@if($step == 1) text-blue-600 dark:text-blue-400 @endif">
                            <h3 class="font-medium leading-tight">Lector</h3>
                            <p class="text-sm">Paso 1</p>
                        </div>
                    </li>

                    <li class="mb-10 ms-8">
                        <span class="absolute flex items-center justify-center w-10 h-10 rounded-full -start-[1.325rem] ring-2
                            @if($this->stepTwoCompleted) bg-green-100 ring-green-200 dark:bg-green-700 dark:ring-green-900
                            @else bg-white ring-white dark:bg-gray-700 dark:ring-gray-900 @endif"
                        >
                            @if ($this->stepTwoCompleted)
                                <x-icons.check class="w-5 h-5 text-green-500 dark:text-green-400" />
                            @else
                                <x-icons.book class="w-5 h-5 text-gray-500 dark:text-gray-400" />
                            @endif
                        </span>

                        <div class="@if($step == 2) text-blue-600 dark:text-blue-400 @endif">
                            <h3 class="font-medium leading-tight">Libro</h3>
                            <p class="text-sm">Paso 2</p>
                        </div>
                    </li>

                    <li class="mb-10 ms-8">
                        <span class="absolute flex items-center justify-center w-10 h-10 rounded-full -start-[1.325rem] ring-2
                            @if($this->stepThreeCompleted) bg-green-100 ring-green-200 dark:bg-green-700 dark:ring-green-900
                            @else bg-white ring-white dark:bg-gray-700 dark:ring-gray-900 @endif"
                        >
                            @if ($this->stepThreeCompleted)
                                <x-icons.check class="w-5 h-5 text-green-500 dark:text-green-400" />
                            @else
                                <x-icons.clipboard-text class="w-5 h-5 text-gray-500 dark:text-gray-400" />
                            @endif
                        </span>

                        <div class="@if($step == 3) text-blue-600 dark:text-blue-400 @endif">
                            <h3 class="font-medium leading-tight">Datos</h3>
                            <p class="text-sm">Paso 3</p>
                        </div>
                    </li>

                    <li class="ms-8">
                        <span class="absolute flex items-center justify-center w-10 h-10 rounded-full -start-[1.325rem] ring-2 ring-white bg-white
                            dark:ring-gray-900 dark:bg-gray-700"
                        >
                            <x-icons.checked-list class="w-5 h-5 text-gray-500 dark:text-gray-400" />
                        </span>

                        <div class="@if($step == 4) text-blue-600 dark:text-blue-400 @endif">
                            <h3 class="font-medium leading-tight">Confirmación</h3>
                            <p class="text-sm">Paso 4</p>
                        </div>
                    </li>
                </ol>
            </div>

            <div class="flex-1 mt-4 lg:mt-0">
                <form wire:submit="save">
                    @if ($step == 1)
                        <div class="px-6 py-4 bg-white dark:bg-gray-800 rounded-md border border-gray-200 dark:border-gray-700 mt-4 lg:mt-0">
                            <div class="flex">
                                <h3 class="text-sm md:text-lg text-gray-700 dark:text-white font-medium">
                                    1. Selecciona el lector
                                </h3>

                                @if ($user_id)
                                    <button
                                        class="text-xs md:text-sm ms-2 font-medium text-blue-600 hover:underline dark:text-blue-500"
                                        type="button"
                                        wire:click="$set('user_id', null)"
                                        @click="$wire.search = ''"
                                    >
                                        &times; Limpiar Selección
                                    </button>
                                @endif
                            </div>

                            <hr class="my-4 -mx-6 dark:border-gray-700">

                            @if (! $user_id)
                                <div>
                                    <div class="relative w-full">
                                        <span class="absolute top-2.5">
                                            <x-icons.search class="w-5 h-5 mx-3 text-gray-400 dark:text-gray-600" />
                                        </span>

                                        <x-input
                                            class="pl-11 w-full"
                                            type="search"
                                            placeholder="Buscar lector..."
                                            wire:model.live.debounce.500ms="search"
                                        />
                                    </div>

                                    <div class="mt-4">
                                        @if ($this->totalUsers)
                                            @forelse ($this->users as $user)
                                                <div
                                                    class="flex items-center gap-4 cursor-pointer text-gray-700 hover:bg-blue-100 dark:hover:bg-blue-900 rounded-md px-2 py-2 my-2"
                                                    wire:key="user-{{ $user->id }}"
                                                    wire:click="$set('user_id', {{ $user->id }})"
                                                >
                                                    <img class="object-cover w-10 h-10 rounded-md" src="{{ $user->profile_photo_url }}" alt="foto de {{ $user->name }}">

                                                    <div>
                                                        <div class="text-sm md:text-base font-medium text-gray-700 dark:text-gray-300">{{ $user->name }}</div>
                                                        <div class="text-xs md:text-sm font-normal text-gray-500 dark:text-gray-400 tracking-wide">{{ $user->email }}</div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="flex justify-center items-center p-2 text-sm text-gray-500">
                                                    <p class="italic">
                                                        No hay coincidencias con su búsqueda
                                                    </p>
                                                </div>
                                            @endforelse
                                        @else
                                            <div class="flex justify-center items-center p-2 text-sm text-gray-500">
                                                <p class="italic">
                                                    No hay lectores disponibles
                                                </p>
                                            </div>
                                        @endif
                                    </div>

                                    {{ $this->users->links('vendor.livewire.custom') }}
                                </div>
                            @else
                                <x-loans.user-data :user="$this->userSelected" />
                            @endif

                            <hr class="my-4 -mx-6 dark:border-gray-700">

                            <div class="flex justify-end">
                                <x-alternative-button
                                    wire:click="setStep(2)"
                                    :disabled="! $this->stepOneCompleted"
                                >
                                    Paso Siguiente
                                    <x-icons.chevron class="inline-flex ms-1 w-4 h-4" />
                                </x-alternative-button>
                            </div>
                        </div>
                    @elseif($step == 2)
                        <div class="px-6 py-4 bg-white dark:bg-gray-800 rounded-md border border-gray-200 dark:border-gray-700 mt-4 lg:mt-0">
                            <div class="flex">
                                <h3 class="text-sm md:text-lg text-gray-700 dark:text-white font-medium">
                                    2. Selecciona el libro
                                </h3>

                                @if ($copy_id)
                                    <button
                                        class="text-xs md:text-sm ms-2 font-medium text-blue-600 hover:underline dark:text-blue-500"
                                        type="button"
                                        wire:click="$set('copy_id', null)"
                                        @click="$wire.search = ''"
                                    >
                                        &times; Limpiar Selección
                                    </button>
                                @endif
                            </div>

                            <hr class="my-4 -mx-6 dark:border-gray-700">

                            @error('copy_unavailable')
                                <x-message-error>
                                    {{ $message }}
                                </x-message-error>
                            @enderror

                            @if (! $copy_id)
                                <div>
                                    <div class="relative w-full">
                                        <span class="absolute top-2.5">
                                            <x-icons.search class="w-5 h-5 mx-3 text-gray-400 dark:text-gray-600" />
                                        </span>

                                        <x-input
                                            class="pl-11 w-full"
                                            type="search"
                                            placeholder="Buscar libro..."
                                            wire:model.live.debounce.500ms="search"
                                        />
                                    </div>

                                    <div class="mt-4">
                                        @if ($this->totalCopies)
                                            @forelse ($this->copies as $copy)
                                                <div
                                                    class="flex items-start gap-4 cursor-pointer text-gray-700 hover:bg-blue-100 dark:hover:bg-blue-900 rounded-md px-2 py-2 my-2"
                                                    wire:key="copy-{{ $copy->id }}"
                                                    wire:click="$set('copy_id', {{ $copy->id }})"
                                                >
                                                    <img class="object-cover h-20 rounded" src="{{ $copy->edition?->cover_url }}" alt="portada de {{ $copy->edition?->book?->title }}">

                                                    <div>
                                                        <div class="text-sm md:text-base font-medium text-gray-700 dark:text-gray-300 first-letter:uppercase">
                                                            {{ $copy->edition?->book?->title }} ({{ $copy->identifier }})
                                                        </div>
                                                        <div class="text-xs md:text-sm font-normal text-gray-500 dark:text-gray-400 tracking-wide">
                                                            <p class="capitalize">
                                                                <span class="font-semibold">editorial:</span>
                                                                {{ $copy->edition?->editorial?->name }}

                                                                <span class="text-base">&bullet;</span>

                                                                <span class="font-semibold">ISBN13:</span>
                                                                {{ $copy->edition?->isbn13 }}
                                                            </p>

                                                            <p class="capitalize">
                                                                <span class="font-semibold">autor:</span>
                                                                {{ $copy->edition?->book?->author?->name }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="flex justify-center items-center p-2 text-sm text-gray-500">
                                                    <p class="italic">
                                                        No hay coincidencias con su búsqueda
                                                    </p>
                                                </div>
                                            @endforelse
                                        @else
                                            <div class="flex justify-center items-center p-2 text-sm text-gray-500">
                                                <p class="italic">
                                                    No hay copias disponibles
                                                </p>
                                            </div>
                                        @endif
                                    </div>

                                    {{ $this->copies->links('vendor.livewire.custom') }}
                                </div>
                            @else
                                <x-loans.copy-data :copy="$this->copySelected" />
                            @endif

                            <hr class="my-4 -mx-6 dark:border-gray-700">

                            <div class="flex justify-between gap-4 mt-4">
                                <x-alternative-button
                                    wire:click="setStep(1)"
                                >
                                    <x-icons.chevron class="inline-flex me-1 w-4 h-4 rotate-180" />
                                    Paso Anterior
                                </x-alternative-button>

                                <x-alternative-button
                                    wire:click="setStep(3)"
                                    :disabled="! $this->stepTwoCompleted"
                                >
                                    Paso Siguiente
                                    <x-icons.chevron class="inline-flex ms-1 w-4 h-4" />
                                </x-alternative-button>
                            </div>
                        </div>
                    @elseif($step == 3)
                        <div class="px-6 py-4 bg-white dark:bg-gray-800 rounded-md border border-gray-200 dark:border-gray-700 mt-4 lg:mt-0">
                            <h3 class="text-sm md:text-lg text-gray-700 dark:text-white font-medium">
                                3. Llena los datos adicionales
                            </h3>

                            <hr class="my-4 -mx-6 dark:border-gray-700">

                            <div>
                                <x-label value="Fecha Límite de Devolución" />

                                <x-input
                                    class="w-full md:w-2/4 mt-1"
                                    x-init="
                                        const limitdatepicker = new CustomDatepicker($el, {
                                            format: 'dd/mm/yyyy',
                                            autohide: true,
                                            language: 'es',
                                            clearBtn: true,
                                            todayBtn: true,
                                            title: 'Fecha Límite de Devolución',
                                        });

                                        limitdatepicker.setDate($wire.limit_date ? $wire.limit_date.replace(/^(\d{4})-(\d\d)-(\d\d)$/, '$3/$2/$1') : null)

                                        $el.addEventListener('changeDate', (event) => $wire.limit_date = limitdatepicker.getDate('yyyy-mm-dd') || '');
                                    "
                                    x-mask="99/99/9999"
                                />

                                <x-input-error for="limit_date" />
                            </div>

                            <div class="mt-6">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input
                                        class="sr-only peer"
                                        type="checkbox"
                                        wire:model.change="is_fineable"
                                    />

                                    <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>

                                    <p class="ms-3 text-gray-700 dark:text-gray-300">
                                        ¿Este préstamo será multable en caso de atraso?
                                    </p>
                                </label>

                                <x-input-error for="is_fineable" />
                            </div>

                            @if ($is_fineable)
                                <div class="mt-4">
                                    <x-label value="Monto Acumulable Diario" />

                                    <x-input
                                        class="w-full md:w-2/4 mt-1"
                                        wire:model="fine_amount"
                                    />

                                    <x-input-error for="fine_amount" />
                                </div>
                            @endif

                            <hr class="my-4 -mx-6 dark:border-gray-700">

                            <div class="flex justify-between gap-4 mt-4">
                                <x-alternative-button
                                    wire:click="setStep(2)"
                                >
                                    <x-icons.chevron class="inline-flex me-1 w-4 h-4 rotate-180" />
                                    Paso Anterior
                                </x-alternative-button>

                                <x-alternative-button
                                    wire:click="setStep(4)"
                                >
                                    Paso Siguiente
                                    <x-icons.chevron class="inline-flex ms-1 w-4 h-4" />
                                </x-alternative-button>
                            </div>
                        </div>
                    @elseif($step == 4)
                        <div class="px-6 py-4 bg-white dark:bg-gray-800 rounded-md border border-gray-200 dark:border-gray-700 mt-4 lg:mt-0">
                            <h3 class="text-sm md:text-lg text-gray-700 dark:text-white font-medium">
                                4. Resumen del préstamo y confirmación
                            </h3>

                            <hr class="my-4 -mx-6 dark:border-gray-700">

                            <x-loans.user-data :user="$this->userSelected" />

                            <x-loans.copy-data :copy="$this->copySelected" />

                            <div>
                                <h4 class="text-sm md:text-base mb-2 text-gray-700 dark:text-gray-400">Información complementaria:</h4>

                                <ul class="text-sm md:text-base ms-4 text-gray-700 dark:text-gray-400 dark:divide-gray-600">
                                    @if ($this->limit_date)
                                        <li class="py-2 sm:flex sm:justify-between sm:gap-4">
                                            <p class="font-medium sm:w-48">
                                                Día Límite de Devolución
                                            </p>

                                            <p class="sm:flex-1 capitalize">
                                                {{ $this->limit_date }}
                                            </p>
                                        </li>
                                    @endif

                                    <li class="py-2 sm:flex sm:justify-between sm:gap-4">
                                        <p class="font-medium sm:w-48">
                                            ¿Es Multable?
                                        </p>

                                        <p class="sm:flex-1 capitalize">
                                            {{ $is_fineable ? 'SI' : 'NO' }}
                                        </p>
                                    </li>

                                    @if ($is_fineable)
                                        <li class="py-2 sm:flex sm:justify-between sm:gap-4">
                                            <p class="font-medium sm:w-48">
                                                Monto de Multa (Diario)
                                            </p>

                                            <p class="sm:flex-1 capitalize">
                                                $ {{ number_format($this->fine_amount, 0, ',', '.') }}
                                            </p>
                                        </li>
                                    @endif
                                </ul>
                            </div>

                            <hr class="my-4 -mx-6 dark:border-gray-700">

                            <div class="flex justify-between gap-4 mt-4">
                                <x-alternative-button
                                    wire:click="setStep(3)"
                                >
                                    <x-icons.chevron class="inline-flex me-1 w-4 h-4 rotate-180" />
                                    Paso Anterior
                                </x-alternative-button>

                                <x-primary-button
                                    type="submit"
                                >
                                    Guardar
                                </x-primary-button>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

@script
    <script type="text/javascript">
        Livewire.on('redirect', () => {
            Livewire.navigate('/back/loans');
        })
    </script>
@endscript
