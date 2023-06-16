<?php

namespace App\DesignPatterns\PaymentType;

use Illuminate\Http\Client\Response as HttpResponse;

interface PaymentTypeInterface {
    public function processPayment(array $data): HttpResponse;
}
