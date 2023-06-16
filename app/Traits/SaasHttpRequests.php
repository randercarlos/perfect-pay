<?php

namespace App\Traits;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

trait SaasHttpRequests
{
    private function baseHttpRequest(): PendingRequest
    {
        return Http
            ::withHeaders([
                'access_token' => config('asaas.api_key'),
            ])
            ->acceptJson();
    }
}
