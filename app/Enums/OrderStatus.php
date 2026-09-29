<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pending = 'pending';
    case Preparing = 'preparing';
    case Ready = 'ready';
    case Courier = 'courier';
    case Delivered = 'delivered';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Создан',
            self::Preparing => 'Готовится',
            self::Ready => 'Готов',
            self::Courier => 'Передан курьеру',
            self::Delivered => 'Доставлен',
            self::Cancelled => 'Отменён',
        };
    }
}