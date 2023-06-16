<?php

namespace App\DesignPatterns\PaymentType;

use App\Exceptions\SaasException;
use Illuminate\Http\Client\Response as HttpResponse;

class BoletoPaymentType implements PaymentTypeInterface
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
            throw new SaasException('Erro ao processar pagamento por Boleto.');
        }
    }

    private function prepareDataForInsert(string $customerId, array $data): array {
        return [
            "customer" => $customerId,
            "billingType" => "BOLETO",
            "dueDate" => today()->format('Y-m-d'),
            "value" => floatval($data['value']),
            "description" => 'Pedido ' . rand(1, 10000)
        ];
    }
}
