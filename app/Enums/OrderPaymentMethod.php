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
            self::Cash => 'Курьеру наличными',
            self::CardOnDelivery => 'Курьеру картой',
            self::Online => 'Онлайн на сайте',
        };
    }
}