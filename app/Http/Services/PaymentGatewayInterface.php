<?php

namespace App\Http\Services;

interface PaymentGatewayInterface
{
    public function generateSignature($params);

    public function validateSignature($params);

    public function validatePayment($params, $payment);

    public function isSuccessful();

    public function process($payment);
}
