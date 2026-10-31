<?php

declare(strict_types=1);

namespace App\Enums;

enum ToothSurface: string
{
    case MESIAL = 'mesial';
    case DISTAL = 'distal';
    case OCCLUSAL = 'occlusal';
    case BUCCAL = 'buccal';
    case LINGUAL = 'lingual';

    public function label(): string
    {
        return match ($this) {
            self::MESIAL => 'Mesial (M) - Toward Midline',
            self::DISTAL => 'Distal (D) - Away From Midline',
            self::OCCLUSAL => 'Occlusal/Incisal (O) - Biting Surface',
            self::BUCCAL => 'Buccal/Facial (B) - Toward Cheek/Lip',
            self::LINGUAL => 'Lingual/Palatal (L) - Toward Tongue/Palate',
        };
    }

    public function shortCode(): string
    {
        return match ($this) {
            self::MESIAL => 'M',
            self::DISTAL => 'D',
            self::OCCLUSAL => 'O',
            self::BUCCAL => 'B',
            self::LINGUAL => 'L',
        };
    }
}
