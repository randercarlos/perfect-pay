<?php

namespace App\Services;

use App\DesignPatterns\PaymentType\BoletoPaymentType;
use App\DesignPatterns\PaymentType\CreditCardPaymentType;
use App\DesignPatterns\PaymentType\PaymentType;
use App\DesignPatterns\PaymentType\PaymentTypeInterface;
use App\DesignPatterns\PaymentType\PixPaymentType;
use App\Models\Client;
use App\Models\Payment;
use App\Repositories\AddressRepository;
use App\Repositories\ClientRepository;
use App\Repositories\PaymentRepository;
use Illuminate\Http\Client\Response as HttpResponse;
use Illuminate\Support\Facades\DB;

class ApiService
{
    public function __construct(private readonly PaymentType       $paymentType,
                                private readonly ClientRepository  $clientRepository,
                                private readonly PaymentRepository $paymentRepository,
                                private readonly AddressRepository $addressRepository)
    {
    }

    public function payment(array $data): array {
        try {
            DB::beginTransaction();

            $data = request()->except(['_token']);
            $paymentTypeObj = $this->getPaymentType($data['billingType']);

            $this->paymentType->setPaymentType($paymentTypeObj);
            $httpResponse = $this->paymentType->processPayment($data);

            $client = $this->saveClientData($data, $httpResponse);
            $this->savePaymentData($data, $client, $httpResponse);

            DB::commit();

            return $this->getPaymentLink($httpResponse, $data);
        } catch(\Exception $exception) {
            DB::rollBack();

            throw $exception;
        }
    }

    private function saveClientData(array $data, HttpResponse $httpResponse): object {
        try {
            $client = $this->clientRepository->create([
                ...$data,
                'saas_client_id' => $this->getCustomerId($httpResponse),
                'cpf' => $data['cpfCnpj'],
                'mobile_phone' => $data['mobilePhone']
            ]);

            $this->saveAddressData($data, $client);

            return $client;
        } catch(\Exception $exception) {
            throw new \Exception('Falha ao salvar dados do cliente.');
        }
    }

    private function savePaymentData(array $data, Client $client, HttpResponse $httpResponse): object {
        try {
            $payment = $this->paymentRepository->create([
                ...$data,
                'saas_payment_id' => $this->getCustomerId($httpResponse),
                'client_id' => $client->id,
                'description' => $this->getOrderDescription($httpResponse),
                'billing_type' => $data['billingType'],
                'value' => floatval($data['value']),
                'due_date' => now()
            ]);

            $this->saveAddressData($data, $payment);

            return $payment;
        } catch(\Exception $exception) {
            dd($exception->getMessage(), $data);
            throw new \Exception('Falha ao salvar dados do pagamento.');
        }
    }

    private function saveAddressData(array $data, Client | Payment $object): object {
        try {
            return $this->addressRepository->create([
                ...$data,
                'address_number' => $data['addressNumber'],
                'uf' => $data['state'],
                'cep' => $data['postalCode'],
                'addressable_id' => $object->id,
                'addressable_type' => $object::class,
            ]);
        } catch(\Exception $exception) {
            throw new \Exception('Falha ao salvar dados do endereço.');
        }
    }

    private function getPaymentType(string $paymentTypeString): PaymentTypeInterface {
        $paymentTypeAvailables = [
            'BOLETO' => new BoletoPaymentType(),
            'CREDIT_CARD' => new CreditCardPaymentType(),
            'PIX' => new PixPaymentType()
        ];

        return $paymentTypeAvailables[$paymentTypeString];
    }

    private function getPaymentLink(HttpResponse $httpResponse, array $data): array {
        $paymentLinkType = [
            'BOLETO' => $data['billingType'] === 'BOLETO' ? $httpResponse?->json('invoiceUrl') : NULL,
            'PIX' => $data['billingType'] === 'PIX' ? $httpResponse?->json() : null
        ];

        return $paymentLinkType;
    }

    private function getCustomerId(HttpResponse $response): ?string  {
        return optional($response->json())['id'];
    }

    private function getOrderDescription(HttpResponse $response): ?string  {
        return optional($response->json())['description'];
    }
}
