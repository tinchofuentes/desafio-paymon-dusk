<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case CASH = 'cash';
    case BANK_TRANSFER = 'bank_transfer';
    
    public function label(): string
    {
        return match($this) {
            self::CASH => 'Efectivo',
            self::BANK_TRANSFER => 'Transferencia Bancaria',
        };
    }
} 