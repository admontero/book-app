<x-front-layout>
    <div class="mt-12 text-center space-y-4">
        @if ($isValidSignature)
            <div>
                @switch($status)
                    @case(App\Enums\PayUResponseStatusEnum::APROBADO->value)
                        <div class="space-y-6">
                            <img class="w-96 mx-auto" src="{{ asset('dist/images/success.png') }}" alt="Status Success Icon">

                            <div>
                                <h2 class="text-xl font-bold text-gray-700 dark:text-white">Pago Aprobado</h2>

                                <p class="italic text-gray-600 dark:text-gray-300">{{ $description }}</p>
                            </div>
                        </div>
                        @break
                    @case(App\Enums\PayUResponseStatusEnum::PENDIENTE->value)
                        <div class="space-y-6">
                            <img class="w-96 mx-auto" src="{{ asset('dist/images/pending.png') }}" alt="Pending Status Icon">

                            <div>
                                <h2 class="text-xl font-bold text-gray-700 dark:text-white">Pago Pendiente</h2>

                                <p class="italic text-gray-600 dark:text-gray-300">{{ $description }}</p>
                            </div>
                        </div>
                        @break
                    @case(App\Enums\PayUResponseStatusEnum::DECLINADO->value)
                        <div class="space-y-6">
                            <img class="w-96 mx-auto" src="{{ asset('dist/images/rejected.png') }}" alt="Rejected Status Icon">

                            <div>
                                <h2 class="text-xl font-bold text-gray-700 dark:text-white">Pago Declinado</h2>

                                <p class="italic text-gray-600 dark:text-gray-300">{{ $description }}</p>
                            </div>
                        </div>
                        @break
                    @case(App\Enums\PayUResponseStatusEnum::EXPIRADO->value)
                        <div class="space-y-6">
                            <img class="w-96 mx-auto" src="{{ asset('dist/images/expired.png') }}" alt="Expired Status Icon">

                            <div>
                                <h2 class="text-xl font-bold text-gray-700 dark:text-white">Pago Expirado</h2>

                                <p class="italic text-gray-600 dark:text-gray-300">{{ $description }}</p>
                            </div>
                        </div>
                        @break
                    @case(App\Enums\PayUResponseStatusEnum::ERROR_INTERNO->value)
                        <div class="space-y-6">
                            <img class="w-96 mx-auto" src="{{ asset('dist/images/error.png') }}" alt="Error Status Icon">

                            <div>
                                <h2 class="text-xl font-bold text-gray-700 dark:text-white">Error Interno en el Pago</h2>

                                <p class="italic text-gray-600 dark:text-gray-300">{{ $description }}</p>
                            </div>
                        </div>
                        @break
                    @default
                @endswitch
            </div>
        @else
            <div class="space-y-6">
                <img class="w-96 mx-auto" src="{{ asset('dist/images/error.png') }}" alt="Error Status Icon">

                <div>
                    <h2 class="text-xl font-bold text-gray-700 dark:text-white">Error de Validación del Pago</h2>

                    <p class="italic text-gray-600 dark:text-gray-300">{{ $description }}</p>
                </div>
            </div>
        @endif

        <a
            class="inline-flex items-center underline underline-offset-2 text-gray-500 dark:text-gray-300
                hover:text-gray-600 dark:hover:text-gray-200"
            href="{{ route('front.fines.index') }}"
        >
            <x-icons.chevron class="w-5 h-5 rotate-180 me-0.5" />
            Volver Atrás
        </a>
    </div>
</x-front-layout>
