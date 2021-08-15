<?php

namespace App\Http\Controllers\Admin;

use App\Http\Services\PaymentGatewayInterface;
use App\Http\Controllers\BaseController;
use View;

class CheckoutOrderController extends BaseController
{
    /**
     * @var PaymentGateway
     */
    protected $paymentGateway;

    public function __construct(PaymentGatewayInterface $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    public function checkout()
    {
        return View::make('admin.payments.index');
    }
}
