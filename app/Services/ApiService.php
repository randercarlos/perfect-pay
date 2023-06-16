<?php

namespace App\Services;

use App\DesignPatterns\PaymentType\BoletoPaymentType;
use App\DesignPatterns\PaymentType\CreditCardPaymentType;
use App\DesignPatterns\PaymentType\PaymentType;
use App\DesignPatterns\PaymentType\PaymentTypeInterface;
use App\DesignPatterns\PaymentType\PixPaymentType;
use Illuminate\Http\Client\Response as HttpResponse;

class ApiService
{
    public function __construct(private readonly PaymentType $paymentType)
    {
    }

    public function payment(array $data): array {
        $data = request()->except(['_token']);
        $paymentTypeObj = $this->getPaymentType($data['billingType']);

        $this->paymentType->setPaymentType($paymentTypeObj);
        $httpResponse = $this->paymentType->processPayment($data);

        return $this->getPaymentLink($httpResponse, $data);
    }

    public function getPaymentType(string $paymentTypeString): PaymentTypeInterface {
        $paymentTypeAvailables = [
            'BOLETO' => new BoletoPaymentType(),
            'CREDIT_CARD' => new CreditCardPaymentType(),
            'PIX' => new PixPaymentType()
        ];

        return $paymentTypeAvailables[$paymentTypeString];
    }

    public function getPaymentLink(HttpResponse $httpResponse, array $data): array {
        $paymentLinkType = [
            'BOLETO' => $data['billingType'] === 'BOLETO' ? $httpResponse?->json('invoiceUrl') : NULL,
            'PIX' => $data['billingType'] === 'PIX' ? $httpResponse?->json() : null
        ];

        return $paymentLinkType;
    }
}
