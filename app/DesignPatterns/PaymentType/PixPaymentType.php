<?php

namespace App\DesignPatterns\PaymentType;

use App\Exceptions\SaasException;
use Illuminate\Http\Client\Response as HttpResponse;

class PixPaymentType implements PaymentTypeInterface
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

            $responsePayment = $this->paymentTypeService->createPayment($this->prepareDataForInsert($customerId, $data));
            $billingId = $responsePayment->json('id');

            return $this->paymentTypeService->getPixQRCode($billingId);
        } catch(\Exception) {
            throw new SaasException('Erro ao processar pagamento por PIX.');
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
