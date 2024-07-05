<div>
    @if (
        $loanStatus == App\Enums\LoanStatusEnum::COMPLETADO->value &&
        $fineStatus == App\Enums\FineStatusEnum::PENDIENTE->value &&
        ! $isLoading
    )
        <div wire:key="fine-form-{{ $this->fineId }}">
            <form wire:submit="submit">
                <button type="submit">
                    <img src="{{ asset('dist/images/payu.svg') }}" width="100" height="100" alt="payu logo">
                </button>
            </form>
        </div>
    @else
        <div
            wire:key="payu-logo-{{ $this->fineId }}"
            @if ($loanStatus != App\Enums\LoanStatusEnum::COMPLETADO->value)
                x-data="{ tooltip: 'El préstamo debe estar completado para habilitar el pago de la multa' }"
                x-tooltip.placement.right.delay.50="tooltip"
            @endif
        >
            <img class="grayscale-[100%]" src="{{ asset('dist/images/payu.svg') }}" width="100" height="100" alt="payu logo">
        </div>
    @endif

    @if ($loanStatus == App\Enums\LoanStatusEnum::COMPLETADO->value && $fineStatus == App\Enums\FineStatusEnum::PENDIENTE->value)
        <div wire:key="pay-u-form-container-{{ $fineId }}">
            <form
                method="POST"
                action="{{ config('services.payu.checkout_url') }}"
                x-data
                x-init="$wire.on('submit-pay-u-form', () => { $nextTick(() => $el.submit()); })"
            >
                <input type="hidden" name="merchantId" value="{{ $merchantId }}">
                <input type="hidden" name="accountId" value="{{ $accountId }}">
                <input type="hidden" name="description" value="{{ $description }}">
                <input type="hidden" name="referenceCode" value="{{ $referenceCode }}">
                <input type="hidden" name="amount" value="{{ $amount }}">
                <input type="hidden" name="tax" value="{{ $tax }}">
                <input type="hidden" name="taxReturnBase" value="{{ $taxReturnBase }}">
                <input type="hidden" name="currency" value="{{ $currency }}">
                <input type="hidden" name="signature" value="{{ $signature }}">
                <input type="hidden" name="test" value="{{ app()->isLocal() ? 1 : 0 }}">
                <input type="hidden" name="buyerFullName" value="{{ $buyerFullName }}">
                <input type="hidden" name="buyerEmail" value="{{ $buyerEmail }}">
                <input type="hidden" name="responseUrl" value="{{ $responseUrl }}">
                <input type="hidden" name="confirmationUrl" value="{{ $confirmationUrl }}">
            </form>
        </div>
    @endif
</div>
