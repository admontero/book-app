<?php

namespace App\Http\Controllers;

use App\Enums\FineStatusEnum;
use App\Enums\PayUResponseStatusEnum;
use App\Models\Payment;
use App\Services\Payments\PayUService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayUController extends Controller
{
    public function __construct(protected PayUService $payUService)
    {}

    public function handleResponse(Request $request)
    {
        $isValidSignature = $this->payUService->isValidSignature(
            $request->signature,
            $this->payUService->generatedResponseSignature($request->referenceCode, $request->TX_VALUE, $request->transactionState, $request->currency)
        );

        return view('front.payments.response', [
            'isValidSignature' => $isValidSignature,
            'description' => $request->description,
            'status' => $request->transactionState,
        ]);
    }

    public function handleConfirmation(Request $request)
    {
        $data = $request->all();

        $isValidSignature = $this->payUService->isValidSignature(
            $data['sign'],
            $this->payUService->generatedConfirmationSignature($data['reference_sale'], $data['value'], $data['state_pol'], $data['currency']),
        );

        if (! $isValidSignature)
            response()->json(['message' => 'Error... Firma de pago incorrecta'], 200);

        $payment = Payment::with(['fine'])->firstWhere('reference', $data['reference_sale']);

        if (! $payment || !$payment->fine)
            response()->json(['message' => 'Error... Multa de Préstamo no encontrada'], 200);

        DB::transaction(function () use ($payment, $data) {
            $payment->update([
                'pay_u_reference' => $data['reference_pol'],
                'payment_method' => $data['payment_method'],
                'payment_method_name' => $data['payment_method_name'],
                'transaction_id' => $data['transaction_id'],
                'transaction_at' => $data['transaction_date'],
                'transaction_state' => $data['state_pol'],
            ]);

            if ($data['state_pol'] == PayUResponseStatusEnum::APROBADO->value)
                $payment->fine()->update(['status' => FineStatusEnum::PAGADA]);
            
        });

        return response()->json([
            'message' => 'Ok... Pago registrado',
        ], 200);
    }
}
