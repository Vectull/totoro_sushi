<?php

namespace App\Filament\Admin\Resources\Orders\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Основная информация')
                    ->schema([
                        TextEntry::make('id')
                            ->label('Номер заказа'),

                        TextEntry::make('created_at')
                            ->label('Создан')
                            ->dateTime('d.m.Y H:i'),

                        TextEntry::make('status')
                            ->label('Статус')
                            ->formatStateUsing(
                                fn ($state) => $state?->label() ?? '—'
                            ),

                        TextEntry::make('payment_status')
                            ->label('Статус оплаты'),

                        TextEntry::make('delivery_method')
                            ->label('Способ получения')
                            ->formatStateUsing(
                                fn ($state) => $state?->label() ?? '—'
                            ),

                        TextEntry::make('payment_method')
                            ->label('Способ оплаты')
                            ->formatStateUsing(
                                fn ($state) => $state?->label() ?? '—'
                            ),
                    ])
                    ->columns(2),

                Section::make('Клиент')
                    ->schema([
                        TextEntry::make('customer_name')
                            ->label('Имя'),

                        TextEntry::make('customer_phone')
                            ->label('Телефон'),

                        TextEntry::make('customer_email')
                            ->label('Email')
                            ->placeholder('Не указан'),

                        TextEntry::make('delivery_address')
                            ->label('Адрес доставки')
                            ->placeholder('Не указан'),

                        TextEntry::make('comment')
                            ->label('Комментарий')
                            ->placeholder('Нет комментария'),
                    ])
                    ->columns(2),

                Section::make('Состав заказа')
                    ->schema([
                        TextEntry::make('items_summary')
                            ->label('')
                            ->state(function ($record): string {
                                return $record->items
                                    ->map(function ($item) {
                                        $line = "{$item->product_name} × {$item->quantity} — "
                                            . number_format(
                                                (float) $item->total,
                                                0,
                                                ',',
                                                ' '
                                            )
                                            . ' ₽';

                                        if (! empty($item->modifiers)) {
                                            $modifiers = collect($item->modifiers)
                                                ->pluck('name')
                                                ->implode(', ');

                                            $line .= " ({$modifiers})";
                                        }

                                        return $line;
                                    })
                                    ->implode("\n");
                            })
                            ->columnSpanFull(),
                    ]),

                Section::make('Итого')
                    ->schema([
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
                    ])
                    ->columns(4),
            ]);
    }
}