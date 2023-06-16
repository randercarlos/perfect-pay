<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Services\ApiService;

class PaymentController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function __invoke(PaymentRequest $request)
    {
        $paymentLinks = $this->apiService->payment($request->validated());

        return redirect()->route('thanks')->with('paymentLinks', $paymentLinks);
    }
}
