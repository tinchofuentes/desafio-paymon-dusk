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
    
    public static function options(): array
    {
        return collect(self::cases())->map(fn($case) => [
            'value' => $case->value,
            'label' => $case->label()
        ])->toArray();
    }
} 