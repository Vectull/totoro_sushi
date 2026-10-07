<?php

namespace App\Enums;

enum OrderDeliveryMethod: string
{
    case Courier = 'courier';
    case Pickup = 'pickup';

    public function label(): string
    {
        return match ($this) {
            self::Courier => 'Доставка курьером',
            self::Pickup => 'Самовывоз',
        };
    }
}