<?php

namespace App\Enums;

enum RequestStatusAdmin: string
{
    case NEW = 'Non traitée';
    case PENDING = 'En attente';
    case PLANNED = 'Planifiée';
    case IN_PROGRESS = 'En cours';
    case RESOLVED = 'Traitée';

    public static function toArray(): array
    {
        $values = [];

        foreach (self::cases() as $props) {
            $values[strtolower($props->name)] = $props->value;
        }

        return $values;
    }
}
