<?php

namespace App\Filament\Admin\Resources\Orders\Schemas;

use App\Enums\OrderStatus;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('status')
                    ->label('Статус заказа')
                    ->options(
                        collect(OrderStatus::cases())
                            ->mapWithKeys(
                                fn (OrderStatus $status) => [
                                    $status->value => $status->label(),
                                ]
                            )
                            ->all()
                    )
                    ->required(),
            ]);
    }
}