<?php

namespace App\Http\Services;

use Illuminate\Http\Response;
use Exception;

class PayfortService implements PaymentGatewayInterface
{
    public $gatewayHost        = 'https://checkout.payfort.com/';
    public $gatewaySandboxHost = 'https://sbcheckout.payfort.com/';
    public $merchantIdentifier = 'MERCHANT_IDENTIFIER';
    public $accessCode         = 'ACCESS_CODE';
    public $SHARequestPhrase   = 'SHA_REQUEST_PASSPHRASE';
    public $SHAResponsePhrase  = 'SHA_RESPONSE_PASSPHRASE';
    public $SHAType       = 'sha256';
    public $command       = 'AUTHORIZATION';
    public $sandboxMode   = true;
    public $paymentMethod = 'creditcard';

    public $language           = '';
    public $amount             = '';
    public $currency           = 'USD';

    public function __construct()
    {
        $this->language = app()->getLocale();
    }

    public function getRedirectionData($payment)
    {
        $merchantReference = $this->generateMerchantReference();
        if ($this->sandboxMode) {
            $gatewayUrl = $this->gatewaySandboxHost . 'FortAPI/paymentPage';
        } else {
            $gatewayUrl = $this->gatewayHost . 'FortAPI/paymentPage';
        }

        $postData = array(
            'amount'              => $this->convertFortAmount($payment->final_amount, $this->currency),
            'currency'            => strtoupper($this->currency),
            'merchant_identifier' => $this->merchantIdentifier,
            'access_code'         => $this->accessCode,
            'merchant_reference'  => $merchantReference,
            'customer_email'      => 'test@payfort.com',
            'customer_name'         => 'mahmoud reda',

            'command'             => $this->command,
            'language'            => $this->language,
            'return_url'          => route('web.payment.route', ['r' => 'processResponse']),
        );
        $postData['signature'] = $this->generateSignature($postData, 'request');

        return array('url' => $gatewayUrl, 'params' => $postData);
    }

    public function generateMerchantReference()
    {
        return rand(0, getrandmax());
    }

    public function convertFortAmount($amount, $currencyCode)
    {
        $new_amount = 0;
        $total = $amount;
        $decimalPoints    = $this->getCurrencyDecimalPoints($currencyCode);
        $new_amount = round($total, $decimalPoints) * (pow(10, $decimalPoints));
        return $new_amount;
    }

    public function getCurrencyDecimalPoints($currency)
    {
        $decimalPoint  = 2;
        $arrCurrencies = array(
            'JOD' => 3,
            'KWD' => 3,
            'OMR' => 3,
            'TND' => 3,
            'BHD' => 3,
            'LYD' => 3,
            'IQD' => 3,
        );
        if (isset($arrCurrencies[$currency])) {
            $decimalPoint = $arrCurrencies[$currency];
        }
        return $decimalPoint;
    }

    public function getPaymentForm($gatewayUrl = "", $postData = [])
    {
        $form = '<form style="display:none" name="payfort_payment_form" id="payfort_payment_form" method="post" action="' . $gatewayUrl . '">';
        foreach ($postData as $k => $v) {
            $form .= '<input type="hidden" name="' . $k . '" value="' . $v . '">';
        }
        $form .= '<input type="submit" id="submit">';
        return $form;
    }

    public function process($payment)
    {
        $data = $this->getRedirectionData($payment);
        $postData = $data['params'];

        try {
            $this->validateSignature($data['params']);
        } catch (\Exception $e) {
            return response()->json($e->getMessage())
                ->setStatusCode($e->getCode());
        }

        try {
            $this->validatePayment($data['params'], $payment);
        } catch (\Exception $e) {
            return response()->json($e->getMessage())
                ->setStatusCode($e->getCode());
        }

        $gatewayUrl = $data['url'];
        $form = $this->getPaymentForm($gatewayUrl, $postData);

        echo json_encode(array('form' => $form, 'url' => $gatewayUrl, 'params' => $postData, 'paymentMethod' => $this->paymentMethod));
    }

    public function generateSignature($params, $signType = 'request')
    {
        $shaString             = '';
        ksort($params);
        foreach ($params as $k => $v) {
            $shaString .= "$k=$v";
        }
        if ($signType == 'request') {
            $shaString = $this->SHARequestPhrase . $shaString . $this->SHARequestPhrase;
        } else {
            $shaString = $this->SHAResponsePhrase . $shaString . $this->SHAResponsePhrase;
        }
        $signature = hash($this->SHAType, $shaString);

        return $signature;
    }

    public function validateSignature($params)
    {
        $calculatedSignature = $this->generateSignature($params, 'response');
        $responseSignature     = $params['signature'];
        if ($responseSignature == $calculatedSignature) {
            throw new Exception('Invalid Signature', Response::HTTP_NOT_ACCEPTABLE);
        }

        return true;
    }

    public function validatePayment($params, $payment)
    {
        if ($payment->final_amount != $params['amount']/100) {
            throw new Exception('Invalid Payment Amount', Response::HTTP_NOT_ACCEPTABLE);
        }
        return true;
    }

    public function isSuccessful()
    {
        $fortParams = array_merge($_GET, $_POST);
        $reason        = '';
        $response_code = '';
        $success = true;

        //validate payfort response
        $params        = $fortParams;
        unset($params['r']);
        unset($params['signature']);
        unset($params['integration_type']);

        $response_code    = $params['response_code'];
        $response_message = $params['response_message'];
        $status           = $params['status'];

        if (substr($response_code, 2) != '000') {
            $success = false;
            $reason  = $response_message;
        }

        if (!$success) {
            $p = $params;
            $p['error_msg'] = $reason;

            //show error page here
        } else {
            //show success page
        }
    }
}
