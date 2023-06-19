<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use LVR\CreditCard\CardCvc;
use LVR\CreditCard\CardNumber;

class PaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "name" => [
                'required',
                'min:5',
                'max:50'
            ],
            "email" => [
                'required', 'email'
            ],
            "cpfCnpj" => [
                'required',
                'cpf'
            ],
            "billingType" => [
                'required',
                Rule::in(['BOLETO', 'CREDIT_CARD', 'PIX']),
            ],
            "address" => [
                'required',
                'min: 5',
            ],
            "addressNumber" => [
                'required',
                'min: 1',
                'max: 10',
            ],
            "complement"  => [
                'min: 1',
                'max: 60',
            ],
            "province" => [
                'required',
                'min: 3',
                'max: 10',
            ],
            "city" =>  [
                'required',
                'min: 3',
                'max: 15',
            ],
            "state" => [
                'required',
                'min: 2',
                'max: 2',
                'uf'
            ],
            "postalCode" => [
                'required',
                'min: 9',
                'max: 9',
                'formato_cep'
            ],
            "card_name" => [
                'required_if:billingType,CREDIT_CARD',
                'same:name',
            ],
            "card_number" => [
                'required_if:billingType,CREDIT_CARD',
                new CardNumber()
            ],
            "expiry" => [
                'required_if:billingType,CREDIT_CARD',
            ],
            "cvv" => [
                'required_if:billingType,CREDIT_CARD',
                'min:3',
                'max:3',
                new CardCvc($this->get('card_number'))
            ],
            "phone" =>  [
                'required',
                'telefone_com_ddd',
            ],
            "mobilePhone" =>  [
                'required',
                'celular_com_ddd',
            ],
            "value" => [
                'required',
                'numeric',
                'min:5'
            ]
        ];
    }


    public function attributes() {
        return [
            'name' => 'Nome',
            'email' => 'Email',
            'cpfCnpj' => 'CPF',
            'billingType' => 'Forma de Pagamento',
            'address' => 'Endereço',
            'addressNumber' => 'Nº do Endereço',
            'complement' => 'Complemento do Endereço',
            'province' => 'Bairro',
            'city' => 'Cidade',
            'state' => 'Estado',
            'postalCode' => 'CEP',
            'card_name' => 'Nome no Cartão de Crédito',
            'card_number' => 'Nº do Cartão de Crédito',
            'expiry' => 'Data de Expiração do Cartão de Crédito',
            'cvv' => 'CVV do Cartão de Crédito',
            'phone' => 'Telefone',
            'mobilePhone' => 'Celular',
            'value' => 'Valor da Compra',
        ];
    }

    public function messages()
    {
        return [
            'value.min' => "O campo Valor da Compra deve ser igual ou maior que R$ 5,00"
        ];
    }
}
