<?php

namespace App\Filament\Admin\Resources\Orders\Tables;

use App\Enums\OrderStatus;
use App\Enums\OrderDeliveryMethod;
use App\Enums\OrderPaymentMethod;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
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
                    )
                    ->color(fn (OrderStatus $state): string => match ($state) {
                        OrderStatus::Pending => 'warning',
                        OrderStatus::Preparing => 'info',
                        OrderStatus::Ready, OrderStatus::Delivered => 'success',
                        OrderStatus::Courier => 'primary',
                        OrderStatus::Cancelled => 'danger',
                    }),

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
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),

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
            ->filters([
                SelectFilter::make('status')
                    ->label('Статус заказа')
                    ->options(collect(OrderStatus::cases())
                        ->mapWithKeys(fn (OrderStatus $status): array => [
                            $status->value => $status->label(),
                        ])
                        ->all()),
                SelectFilter::make('delivery_method')
                    ->label('Способ получения')
                    ->options(collect(OrderDeliveryMethod::cases())
                        ->mapWithKeys(fn (OrderDeliveryMethod $method): array => [
                            $method->value => $method->label(),
                        ])
                        ->all()),
                SelectFilter::make('payment_method')
                    ->label('Способ оплаты')
                    ->options(collect(OrderPaymentMethod::cases())
                        ->mapWithKeys(fn (OrderPaymentMethod $method): array => [
                            $method->value => $method->label(),
                        ])
                        ->all()),
                SelectFilter::make('payment_status')
                    ->label('Статус оплаты')
                    ->options([
                        'pending' => 'Ожидает оплаты',
                        'paid' => 'Оплачен',
                        'failed' => 'Ошибка оплаты',
                        'refunded' => 'Возвращён',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                ViewAction::make(),
                EditAction::make()->label('Изменить статус'),
            ]);
    }
}
