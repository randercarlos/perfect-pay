<!DOCTYPE html>
<html>
<head>
    <title>Checkout Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .center {
            text-align: center;
        }

        .block {
            display: block
        }

        .margin20 {
            margin-bottom: 20px;
        }

        .qrcode {
            width: 300px;
        }

        .bold {
            font-weight: bold
        }
    </style>
</head>
<body>
<h1 class="center">Obrigado pela sua compra!</h1>

<p class="center margin20">
@if (optional(session('paymentLinks'))['BOLETO'])
    <p class="center">Link para pagamento em boleto: {{ session('paymentLinks')['BOLETO'] }}</p>
@elseif (optional(session('paymentLinks'))['PIX'])
    <div class="center">
        <img class="qrcode" src="data:image/png;base64,{{ session('paymentLinks')['PIX']['encodedImage'] }}" alt="QR Code" />
    </div>
    <p class="center">Pix Copia e Cola:</p>
    <p class="center">{{ session('paymentLinks')['PIX']['payload'] }}</p>
    <p class="center">Pagamento válido até <span class="bold">{{ formatToFullBRDate(session('paymentLinks')['PIX']['expirationDate']) }}</span></p>
@endif
</p>

<a href="{{ route('checkout') }}" class="block center">Realizar novo checkout</a>
</body>
</html>
