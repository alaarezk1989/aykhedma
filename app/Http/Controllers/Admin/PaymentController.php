<?php

namespace App\Http\Controllers\Admin;

use App\Http\Services\PaymentGatewayInterface;
use App\Http\Controllers\BaseController;
use App\Http\Services\PaymentService;
use Symfony\Component\HttpFoundation\Request;

class PaymentController extends BaseController
{

    protected $paymentGateway;
    protected $paymentService;

    public function __construct(PaymentGatewayInterface $paymentGateway, PaymentService $paymentService)
    {
        $this->paymentGateway = $paymentGateway;
        $this->paymentService = $paymentService;
    }

    public function route(Request $request)
    {
        $request->request->add(['amount' => 500, 'order_id' => 1, 'gateway' => 'payfort', 'gateway_reference' => "111"]);

        $payment = $this->paymentService->createDraft($request);

        if ($request['r'] == 'getPaymentPage') {
            $this->paymentGateway->process($payment);
        } elseif ($request['r'] == 'processResponse') {
            $this->paymentGateway->isSuccessful();
        }
    }
}
