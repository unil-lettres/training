<?php

namespace App\Enums;

enum UserRole: string
{
    case NOTIFICATION = 'Notification';
    case SUPER_EDITOR = 'Super Éditeur';
    case ADMIN = 'Admin';

    public static function toArray(): array
    {
        $values = [];

        foreach (self::cases() as $props) {
            $values[strtolower($props->name)] = $props->value;
        }

        return $values;
    }
}
