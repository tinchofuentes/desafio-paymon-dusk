<?php

namespace App\Enums;

enum Gender: string
{
    case MALE = 'male';
    case FEMALE = 'female';
    case OTHER = 'other';
    
    public function label(): string
    {
        return match($this) {
            self::MALE => 'Masculino',
            self::FEMALE => 'Femenino',
            self::OTHER => 'Otro',
        };
    }
} 