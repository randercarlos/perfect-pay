<?php

namespace App\DesignPatterns\PaymentType;

use App\Exceptions\SaasException;
use App\Traits\SaasHttpRequests;
use Illuminate\Http\Client\Response as HttpResponse;

class PaymentTypeService
{
    use SaasHttpRequests;

    public function createPayment(array $data): HttpResponse
    {
        $response = $this
            ->baseHttpRequest()
            ->post(config('asaas.base_url') . '/payments', $data) ;

        if ($response->failed()) {
            dd($response->json());
            throw new SaasException('Erro ao processar pagamento.');
        }

        return $response;
    }

    public function createCustomer(array $data): HttpResponse  {
        $response = $this
            ->baseHttpRequest()
            ->post(config('asaas.base_url') . '/customers', $data);

        if ($response->failed()) {
            throw new SaasException('Erro ao criar um novo cliente.');
        }

        return $response;
    }


    public function getCustomerId(HttpResponse $response): ?string  {
        return optional($response->json())['id'];
    }

    public function getPixQRCode(string $billingId): HttpResponse  {
        $response = $this
            ->baseHttpRequest()
            ->get(config('asaas.base_url') . "/payments/$billingId/pixQrCode");

        if ($response->failed()) {
            throw new SaasException('Erro ao gerar QR Code para pagamento via PIX.');
        }

        return $response;
    }
}
