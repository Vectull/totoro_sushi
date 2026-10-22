<?php

namespace App\Filament\Admin\Resources\Orders\Tables;

use App\Enums\OrderStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('№')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('customer_name')
                    ->label('Клиент')
                    ->searchable(),

                TextColumn::make('customer_phone')
                    ->label('Телефон')
                    ->searchable(),

                TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->formatStateUsing(
                        fn (OrderStatus $state) => $state->label()
                    ),

                TextColumn::make('delivery_method')
                    ->label('Получение')
                    ->formatStateUsing(
                        fn ($state) => $state?->label() ?? '—'
                    )
                    ->badge(),

                TextColumn::make('payment_method')
                    ->label('Способ оплаты')
                    ->formatStateUsing(
                        fn ($state) => $state?->label() ?? '—'
                    )
                    ->badge(),

                TextColumn::make('payment_status')
                    ->label('Статус оплаты')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'pending' => 'Ожидает оплаты',
                        'paid' => 'Оплачен',
                        'failed' => 'Ошибка оплаты',
                        'refunded' => 'Возвращён',
                        default => $state ?? '—',
                    })
                    ->badge(),

                TextColumn::make('chopsticks_quantity')
                    ->label('Палочки')
                    ->sortable(),

                TextColumn::make('total')
                    ->label('Сумма')
                    ->money('RUB')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Создан')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([]),
            ]);
    }
}
