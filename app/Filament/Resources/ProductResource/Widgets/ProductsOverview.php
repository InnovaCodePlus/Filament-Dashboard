<?php

namespace App\Filament\Resources\ProductResource\Widgets;

use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProductsOverview extends BaseWidget
{
    protected function getStats(): array
    {


        return [
            static::getProductsStat()
        ];
    }

    public static function getProductsStat()
    {
        $totalProducts = Product::count();

        return Stat::make('Productos', $totalProducts)
            ->description("Productos registrados en el sistema")
            ->chart([7, 0, 55, 23, 2])
            ->color('primary');
    }
}
