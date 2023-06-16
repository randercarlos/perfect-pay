<?php

namespace App\DesignPatterns\PaymentType;

use App\Exceptions\SaasException;
use Illuminate\Support\Str;
use Illuminate\Http\Client\Response as HttpResponse;

class CreditCardPaymentType implements PaymentTypeInterface
{
    private PaymentTypeService $paymentTypeService;

    public function __construct()
    {
        $this->paymentTypeService = new PaymentTypeService();
    }

    public function processPayment(array $data): HttpResponse
    {
        try {
            $response = $this->paymentTypeService->createCustomer($data);
            $customerId = $this->paymentTypeService->getCustomerId($response);

            return $this->paymentTypeService->createPayment($this->prepareDataForInsert($customerId, $data));
        } catch(\Exception) {
            throw new SaasException('Erro ao processar pagamento por cartão de crédito.');
        }
    }

    private function prepareDataForInsert(string $customerId, array $data): array {
        return [
            "customer" => $customerId,
            "billingType" => "CREDIT_CARD",
            "dueDate" => today()->format('Y-m-d'),
            "value" => floatval($data['value']),
            "description" => "Pedido " . rand(7000, 11000),
            "creditCard" => [
                "holderName" => $data['card_name'],
                "number" => $data['card_number'],
                "expiryMonth" => Str::before($data['expiry'], '/') ,
                "expiryYear" => Str::after($data['expiry'], '/') ,
                "ccv" => $data['cvv']
            ],
            "creditCardHolderInfo" => [
                "name" => $data['name'],
                "email" => $data['email'],
                "cpfCnpj" => $data['cpfCnpj'],
                "postalCode" => $data['postalCode'],
                "address"  => $data['address'],
                "addressNumber" => $data['addressNumber'],
                "addressComplement" => $data['complement'],
                "phone" => $data['phone'],
                "mobilePhone" => $data['mobilePhone'],
                "city" => $data['city'],
                "uf" => $data['state']
            ],
        ];
    }
}
