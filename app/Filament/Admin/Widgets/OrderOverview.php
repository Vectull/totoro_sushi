<?php

namespace App\Filament\Admin\Widgets;

use App\Enums\OrderStatus;
use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrderOverview extends StatsOverviewWidget
{
    protected ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        return [
            Stat::make('Новые за сегодня', Order::query()
                ->whereDate('created_at', today())
                ->count())
                ->description('Заказы, оформленные сегодня')
                ->color('primary'),
            Stat::make('Ожидают принятия', Order::query()
                ->where('status', OrderStatus::Pending->value)
                ->count())
                ->description('Статус «Создан»')
                ->color('warning'),
            Stat::make('Готовятся', Order::query()
                ->where('status', OrderStatus::Preparing->value)
                ->count())
                ->description('Статус «Готовится»')
                ->color('info'),
            Stat::make('Готовы к выдаче', Order::query()
                ->where('status', OrderStatus::Ready->value)
                ->count())
                ->description('Ожидают самовывоза или курьера')
                ->color('success'),
            Stat::make('У курьера', Order::query()
                ->where('status', OrderStatus::Courier->value)
                ->count())
                ->description('Ожидают доставки')
                ->color('primary'),
        ];
    }
}
