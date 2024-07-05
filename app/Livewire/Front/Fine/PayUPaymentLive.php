<?php

namespace App\Livewire\Front\Fine;

use App\Models\Fine;
use App\Services\Payments\PayUService;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Livewire\Attributes\Locked;
use Livewire\Component;

class PayUPaymentLive extends Component
{
    private $payUService;

    #[Locked]
    public $fineId;

    #[Locked]
    public $fineStatus;

    #[Locked]
    public $loanStatus;

    public $merchantId;

    public $accountId;

    public $signature;

    public $test;

    public $referenceCode;

    public $description;

    public $amount;

    public $buyerFullName;

    public $buyerEmail;

    public $currency;

    public $tax;

    public $taxReturnBase;

    public $responseUrl;

    public $confirmationUrl;

    public $isLoading = false;

    public function boot(PayUService $payUService): void
    {
        $this->payUService = $payUService;
    }

    public function submit()
    {
        $fine = Fine::findOrFail($this->fineId);

        $reference = IdGenerator::generate(['table' => 'payments', 'field' => 'reference', 'length' => 10, 'prefix' => date('ym')]);

        $fine->payments()->create(['reference' => $reference]);

        $this->fill($this->payUService->fineCheckoutData($fine, $reference));

        $this->isLoading = true;

        $this->dispatch('loading-pay-u-checkout')->to(ListLive::class);
        $this->dispatch('submit-pay-u-form')->self();
    }

    public function render()
    {
        return view('livewire.front.fine.pay-u-payment-live');
    }
}
