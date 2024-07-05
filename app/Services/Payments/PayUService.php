<?php

namespace App\Services\Payments;

use App\Models\Fine;

class PayUService
{
    protected string $apiKey;
    protected string $merchantId;

    public function __construct()
    {
        $this->apiKey = config('services.payu.api_key');
        $this->merchantId = config('services.payu.merchant_id');
    }

    public function signature(string $referenceCode, string $amount, string $currency = 'COP'): string
    {
        return md5("{$this->apiKey}~{$this->merchantId}~{$referenceCode}~{$amount}~{$currency}");
    }

    public function generatedResponseSignature(string $referenceCode, string $amount, int $transactionState, string $currency = 'COP'): string
    {
        $new_amount = sprintf('%.1f', round($amount, 1, PHP_ROUND_HALF_ODD));

        return md5("{$this->apiKey}~{$this->merchantId}~{$referenceCode}~{$new_amount}~{$currency}~{$transactionState}");
    }

    public function generatedConfirmationSignature(string $referenceSale, string $value, string $state_pol, string $currency = 'COP'): string
    {
        $new_value = $value;

        if (get_decimal_digit_in_a_number($value, 2) === '0') {
            $new_value = sprintf('%.1f', round($value, 1, PHP_ROUND_HALF_DOWN));
        }

        return md5("{$this->apiKey}~{$this->merchantId}~{$referenceSale}~{$new_value}~{$currency}~{$state_pol}");
    }

    public function isValidSignature(string $payuSignature, string $generatedSignature): bool
    {
        return strtoupper($payuSignature) == strtoupper($generatedSignature);
    }

    public function fineCheckoutData(Fine $fine, string $referenceCode): array
    {
        $fine->load([
            'user:id,name,email',
            'loan:id,copy_id,serial',
            'loan.copy:id,edition_id,identifier',
            'loan.copy.edition:id,book_id',
            'loan.copy.edition.book:id,title',
        ]);

        $description = "Multa del préstamo {$fine->loan?->serial} de la copia del libro:
            {$fine->loan?->copy?->edition?->book?->title} ({$fine->loan?->copy?->identifier})";

        return [
            'merchantId' => config('services.payu.merchant_id'),
            'accountId' => config('services.payu.account_id'),
            'description' => $description,
            'referenceCode' => $referenceCode,
            'amount' => $fine->total,
            'tax' => 0,
            'taxReturnBase' => 0,
            'currency' => 'COP',
            'signature' => $this->signature($referenceCode, $fine->total),
            'test' => app()->isLocal() ? 1 : 0,
            'buyerFullName' => $fine->user->name,
            'buyerEmail' => $fine->user->email,
            'responseUrl' => route('front.fines.payments.response'),
            'confirmationUrl' => route('payments.payu.confirmation'),
        ];
    }
}
