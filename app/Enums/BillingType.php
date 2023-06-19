<?php

namespace App\Enums;

enum BillingType: string {
    case Boleto = 'BOLETO';
    case CreditCard = 'CREDIT_CARD';
    case Pix = 'PIX';

    public static function getLabel(self $value): string {
        return match ($value) {
            BillingType::Boleto => 'Boleto',
            BillingType::CreditCard => 'Cartão de Crédito',
            BillingType::Pix => 'Pix',
        };
    }
}
