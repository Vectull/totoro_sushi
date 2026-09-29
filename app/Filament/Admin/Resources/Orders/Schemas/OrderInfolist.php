<?php

namespace App\Filament\Admin\Resources\Orders\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('Номер заказа'),

                TextEntry::make('created_at')
                    ->label('Создан')
                    ->dateTime('d.m.Y H:i'),

                TextEntry::make('status')
                    ->label('Статус'),

                TextEntry::make('payment_status')
                    ->label('Статус оплаты'),

                TextEntry::make('customer_name')
                    ->label('Клиент'),

                TextEntry::make('customer_phone')
                    ->label('Телефон'),

                TextEntry::make('customer_email')
                    ->label('Email')
                    ->placeholder('Не указан'),

                TextEntry::make('delivery_address')
                    ->label('Адрес доставки'),

                TextEntry::make('comment')
                    ->label('Комментарий')
                    ->placeholder('Нет комментария'),

                TextEntry::make('subtotal')
                    ->label('Товары')
                    ->money('RUB'),

                TextEntry::make('delivery_cost')
                    ->label('Доставка')
                    ->money('RUB'),

                TextEntry::make('discount')
                    ->label('Скидка')
                    ->money('RUB'),

                TextEntry::make('total')
                    ->label('Итого')
                    ->money('RUB'),
            ]);
    }
}