<!DOCTYPE html>
<html>
<head>
    <title>Checkout Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .checkout-form {
            max-width: 800px;
            margin: 0 auto;
        }

        .center {
            text-align: center;
        }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/mask@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#maskValue').maskMoney({ prefix:'R$ ', decimal: ',', thousands: '.' });

            $('#pay').click(function() {
                $(this).text('carregando...').prop('disabled', true);

                $('#value').val($('#maskValue').maskMoney('unmasked')[0]);

                // Submit the form or perform other actions
                $('#formCheckout').submit();
            });
        });
    </script>
</head>
<body>
<div class="container">
    <div class="checkout-form" x-data="{ billingType: 'BOLETO' }">
        <h3 class="center">Preencha os dados para pagamento</h3>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="post" action="{{ route('pay') }}" id="formCheckout">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="name">Nome</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Informe o nome completo..."
                        value="{{ old('name') }}" />
                </div>
                <div class="form-group col-md-4">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Informe o endereço de email..."
                           value="{{ old('email') }}"/>
                </div>
                <div class="form-group col-md-4">
                    <label for="cpf">CPF</label>
                    <input type="text" class="form-control" id="cpfCnpj" placeholder="Informe o seu CPF..."
                           x-mask="999.999.999-99" name="cpfCnpj"
                           value="{{ old('cpfCnpj') }}" />
                </div>
            </div>

            <div class="form-row" style="margin: 10px 0">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="billingType" id="BoletoBillingType" value="BOLETO"
                        x-model="billingType" checked />
                    <label class="form-check-label" for="BoletoBillingType">Boleto</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="billingType" id="CreditCardBillingType"
                        value="CREDIT_CARD" x-model="billingType" />
                    <label class="form-check-label" for="CreditCardBillingType">Cartão de Crédito</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="billingType" id="PixBillingType" value="PIX"
                        x-model="billingType" checked />
                    <label class="form-check-label" for="PixBillingType">Pix</label>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-10">
                    <label for="address">Endereço</label>
                    <input type="text" class="form-control" id="address" placeholder="Informe o seu endereço..."
                           name="address"  value="{{ old('address') }}"/>
                </div>
                <div class="form-group col-md-2">
                    <label for="address">Nº</label>
                    <input type="text" class="form-control" id="addressNumber" placeholder="Informe o seu endereço..."
                           name="addressNumber" maxlength="7" value="{{ old('addressNumber') }}"/>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="complement">Complemento</label>
                    <input type="text" class="form-control" id="complement" placeholder="Informe o complemento"
                           name="complement" value="{{ old('complement') }}" />
                </div>
                <div class="form-group col-md-2">
                    <label for="city">Bairro</label>
                    <input type="text" class="form-control" id="province" placeholder="Informe a sua cidade..."
                           name="province" value="{{ old('province') }}" />
                </div>
                <div class="form-group col-md-2">
                    <label for="city">Cidade</label>
                    <input type="text" class="form-control" id="city" placeholder="Informe a sua cidade..."
                           name="city" value="{{ old('city') }}" />
                </div>
                <div class="form-group col-md-2">
                    <label for="state">Estado</label>
                    <select class="form-control" name="state" id="state" placeholder="Selecione o seu estado...">
                        <option value="">Selecione um estado</option>
                        <option value="AC">Acre</option>
                        <option value="AL">Alagoas</option>
                        <option value="AP">Amapá</option>
                        <option value="AM">Amazonas</option>
                        <option value="BA">Bahia</option>
                        <option value="CE">Ceará</option>
                        <option value="DF">Distrito Federal</option>
                        <option value="ES">Espírito Santo</option>
                        <option value="GO">Goiás</option>
                        <option value="MA">Maranhão</option>
                        <option value="MT">Mato Grosso</option>
                        <option value="MS">Mato Grosso do Sul</option>
                        <option value="MG">Minas Gerais</option>
                        <option value="PA">Pará</option>
                        <option value="PB">Paraíba</option>
                        <option value="PR">Paraná</option>
                        <option value="PE">Pernambuco</option>
                        <option value="PI">Piauí</option>
                        <option value="RJ">Rio de Janeiro</option>
                        <option value="RN">Rio Grande do Norte</option>
                        <option value="RS">Rio Grande do Sul</option>
                        <option value="RO">Rondônia</option>
                        <option value="RR">Roraima</option>
                        <option value="SC">Santa Catarina</option>
                        <option value="SP">São Paulo</option>
                        <option value="SE">Sergipe</option>
                        <option value="TO">Tocantins</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="cep">CEP</label>
                    <input type="text" class="form-control" id="postalCode" placeholder="Informe o seu CEP"
                           x-mask="99999-999" name="postalCode" value="{{ old('postalCode') }}" />
                </div>
            </div>
            <template x-if="billingType === 'CREDIT_CARD'">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="card_name">Nome no Cartão</label>
                        <input type="text" class="form-control" id="card_name" name="card_name"
                               placeholder="Informe o número do cartão de crédito..." />
                    </div>
                    <div class="form-group col-md-4">
                        <label for="card_number">Número do Cartão</label>
                        <input type="text" class="form-control" id="card_number" name="card_number"
                            placeholder="Informe o número do cartão de crédito..."  x-mask="9999 9999 9999 9999" />
                    </div>
                    <div class="form-group col-md-2">
                        <label for="expiry">Expiração</label>
                        <input type="text" class="form-control" id="expiry" name="expiry"
                               x-mask="99/9999" placeholder="MM/YYYY"/>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="cvv">CVV</label>
                        <input type="text" class="form-control" id="cvv" placeholder="Informe o CVV..." x-mask="999"
                               name="cvv" />
                    </div>
                </div>
            </template>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="phone">Telefone</label>
                    <input type="text" class="form-control" id="phone" placeholder="Informe o telefone..."
                           x-mask="(99) 9999-9999" name="phone" value="{{ old('phone') }}" />
                </div>
                <div class="form-group col-md-6">
                    <label for="cellphone">Celular</label>
                    <input type="text" class="form-control" id="mobilePhone" x-mask="(99) 99999-9999"
                           placeholder="(xx) xxxxx-xxxx" name="mobilePhone" value="{{ old('mobilePhone') }}" />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="total_value">Valor da Compra</label>
                    <input type="text" class="form-control" id="maskValue" placeholder="Informe o valor total da compra..."
                        name="maskValue" />
                    <input type="hidden" class="form-control" id="value" placeholder="Informe o valor total da compra..."
                           name="value" value="{{ old('value') }}" />
                </div>
            </div>

            <div class="form-row" >
                <button type="submit" class="btn btn-primary" id="pay">Pagar</button>
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            </div>
        </form>
    </div>
</div>
</body>
</html>
