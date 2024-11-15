<?php

namespace App\Enums;

enum RequestType: string
{
    case TRAINING = 'Formation';
    case ANALYSIS = 'Analyse';

    public static function toArray(): array
    {
        $values = [];

        foreach (self::cases() as $props) {
            $values[strtolower($props->name)] = $props->value;
        }

        return $values;
    }
}
