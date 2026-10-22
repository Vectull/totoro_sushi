<?php

namespace App\Enums;

enum OrderPaymentMethod: string
{
    case Cash = 'cash';
    case CardOnDelivery = 'card_on_delivery';
    case Online = 'online';

    public function label(): string
    {
        return match ($this) {
            self::Cash => 'Наличными при получении',
            self::CardOnDelivery => 'Картой при получении',
            self::Online => 'Онлайн на сайте',
        };
    }
}
