<?php

namespace App\Enums;

enum EnrollmentStatus: string
{
    case PENDING = 'pending';
    case CONFIRMED = 'confirmed';
    case CANCELLED = 'cancelled';
    
    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Pendiente',
            self::CONFIRMED => 'Confirmado',
            self::CANCELLED => 'Cancelado',
        };
    }
} 