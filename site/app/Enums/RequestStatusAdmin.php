<?php

namespace App\Enums;

enum RequestStatusAdmin: string
{
    case NEW = 'Nouveau';
    case PENDING = 'En attente';
    case RESOLVED = 'Résolue';

    public static function toArray(): array
    {
        $values = [];

        foreach (self::cases() as $props) {
            $values[strtolower($props->name)] = $props->value;
        }

        return $values;
    }
}
