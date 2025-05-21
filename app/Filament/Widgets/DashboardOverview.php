<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\CustomerResource\Widgets\NewCustomerOverview;
use App\Filament\Resources\OrderResource\Widgets\NewOrdersOverview;
use App\Filament\Resources\ProductResource\Widgets\ProductsOverview;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            ProductsOverview::getProductsStat(),
            NewOrdersOverview::getNewOrdersStat(),
            NewCustomerOverview::getNewCustomersStat(),
        ];
    }
}
