<?php

namespace App\DesignPatterns\PaymentType;

use Illuminate\Http\Client\Response as HttpResponse;

class PaymentType implements PaymentTypeInterface
{
    private PaymentTypeInterface $paymentType;
    public function setPaymentType(PaymentTypeInterface $paymentType)
    {
        $this->paymentType = $paymentType;
    }

    public function processPayment(array $data): HttpResponse
    {
        return $this->paymentType->processPayment($data);
    }
}
