<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class NewOrdersOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            static::getNewOrdersStat(),
        ];
    }

    public static function getNewOrdersStat()
    {
        $newOrders = Order::whereMonth('created_at', now()->month)->count();
        $beforeOrders = Order::whereMonth('created_at', now()->month - 1)->count();
        // $beforeOrders = 100;

        $colorStatus = ($newOrders > $beforeOrders) ? 'success' : 'danger';

        $tredingUp = "heroicon-o-arrow-trending-up";
        $tredingDown = "heroicon-o-arrow-trending-down";


        return Stat::make('Nuevas ventas', $newOrders)
            ->description("Ventas generadas este mes")
            ->descriptionIcon(($newOrders > $beforeOrders) ? $tredingUp : $tredingDown)
            ->chart([$beforeOrders, $newOrders])
            ->color($colorStatus);
    }
}
