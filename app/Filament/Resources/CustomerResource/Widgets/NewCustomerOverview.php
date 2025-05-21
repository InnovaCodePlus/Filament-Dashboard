<?php

namespace App\Filament\Resources\CustomerResource\Widgets;

use App\Models\Customer;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class NewCustomerOverview extends BaseWidget
{
    protected static bool $isLazy = false;

    protected static ?string $pollingInterval = '5s';

    protected function getStats(): array
    {
        return [
            static::getNewCustomersStat()
        ];
    }

    public static function getNewCustomersStat()
    {
        $newClients = Customer::whereMonth('created_at', now()->month)->count();
        $beforeClients = Customer::whereMonth('created_at', now()->month - 1)->count();

        return Stat::make('Nuevos clientes', $newClients)
            ->description("Clientes registrados este mes")
            ->chart([$beforeClients, $newClients])
            ->color('primary');
    }
}
