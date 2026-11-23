<?php

declare(strict_types=1);

namespace App\Enums;

enum ToothCondition: string
{
    case SOUND_HEALTHY = 'sound_healthy';
    case CARIES_DECAY = 'caries_decay';
    case EXISTING_AMALGAM_FILLING = 'existing_amalgam_filling';
    case EXISTING_COMPOSITE_FILLING = 'existing_composite_filling';
    case EXISTING_CROWN = 'existing_crown';
    case MISSING_EXTRACTED = 'missing_extracted';
    case IMPACTED = 'impacted';
    case ROOT_CANAL_TREATED = 'root_canal_treated';
    case IMPLANT_RESTORED = 'implant_restored';
    case FRACTURED = 'fractured';
    case MOBILITY_GRADE_1 = 'mobility_grade_1';
    case MOBILITY_GRADE_2 = 'mobility_grade_2';
    case MOBILITY_GRADE_3 = 'mobility_grade_3';
    case EXTRACTION_INDICATED = 'extraction_indicated';

    public function label(): string
    {
        return match ($this) {
            self::SOUND_HEALTHY => 'Sound / Healthy Tooth',
            self::CARIES_DECAY => 'Active Caries / Decay',
            self::EXISTING_AMALGAM_FILLING => 'Existing Amalgam Filling',
            self::EXISTING_COMPOSITE_FILLING => 'Existing Composite Filling',
            self::EXISTING_CROWN => 'Full Coverage Crown',
            self::MISSING_EXTRACTED => 'Missing / Extracted Tooth',
            self::IMPACTED => 'Impacted Tooth',
            self::ROOT_CANAL_TREATED => 'Root Canal Treated',
            self::IMPLANT_RESTORED => 'Dental Implant Restored',
            self::FRACTURED => 'Fractured / Broken Crown',
            self::MOBILITY_GRADE_1 => 'Mobility Grade I',
            self::MOBILITY_GRADE_2 => 'Mobility Grade II',
            self::MOBILITY_GRADE_3 => 'Mobility Grade III',
            self::EXTRACTION_INDICATED => 'Extraction Indicated',
        };
    }

    public function visualColor(): string
    {
        return match ($this) {
            self::SOUND_HEALTHY => '#4CAF50',              // Green
            self::CARIES_DECAY => '#E53935',               // Vibrant Red
            self::EXISTING_AMALGAM_FILLING => '#757575',   // Silver Grey
            self::EXISTING_COMPOSITE_FILLING => '#1E88E5', // Blue
            self::EXISTING_CROWN => '#FBC02D',             // Gold Yellow
            self::MISSING_EXTRACTED => '#BDBDBD',          // Light Grey
            self::IMPACTED => '#8E24AA',                   // Deep Purple
            self::ROOT_CANAL_TREATED => '#00897B',         // Teal
            self::IMPLANT_RESTORED => '#3949AB',           // Indigo
            self::FRACTURED => '#FB8C00',                  // Amber Orange
            self::MOBILITY_GRADE_1 => '#FFB300',           // Amber
            self::MOBILITY_GRADE_2 => '#FB8C00',           // Orange
            self::MOBILITY_GRADE_3 => '#D81B60',           // Pink Red
            self::EXTRACTION_INDICATED => '#C62828',       // Dark Red
        };
    }
}
