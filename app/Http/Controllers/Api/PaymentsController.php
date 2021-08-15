<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use App\Http\Services\PaymentService;
use App\Http\Requests\Api\PaymentRequest;

class PaymentsController extends Controller
{
    public function store(PaymentRequest $request, PaymentService $paymentService)
    {
        $payment = $paymentService->createDraft($request);

        return response()->json($payment);
    }
}
