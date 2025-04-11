<?php

namespace App\Enums;

enum CourseModality: string
{
    case IN_PERSON = 'in-person';
    case ONLINE = 'online';
    case HYBRID = 'hybrid';
    
    public function label(): string
    {
        return match($this) {
            self::IN_PERSON => 'Presencial',
            self::ONLINE => 'En línea',
            self::HYBRID => 'Híbrido',
        };
    }
} 