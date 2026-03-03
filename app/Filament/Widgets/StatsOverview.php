<?php

namespace App\Filament\Widgets;

use App\Models\Car;
use App\Models\Contact;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        // Calculate total sales (sold cars value)
        $totalSales = Car::where('sold', true)->sum('price');
        $soldCarsCount = Car::where('sold', true)->count();
        
        // Available cars
        $availableCars = Car::where('sold', false)->count();
        
        // Featured cars
        $featuredCars = Car::where('featured', true)->where('sold', false)->count();
        
        // Recent contacts (last 30 days)
        $recentContacts = Contact::where('created_at', '>=', now()->subDays(30))->count();
        
        // Total inventory value
        $totalInventoryValue = Car::where('sold', false)->sum('price');

        return [
            Stat::make('Total Sales', 'Rp ' . number_format($totalSales, 0, ',', '.'))
                ->description($soldCarsCount . ' cars sold')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success')
                ->chart([7, 5, 10, 8, 12, 15, $soldCarsCount]),
            
            Stat::make('Available Cars', $availableCars)
                ->description('Ready for sale')
                ->descriptionIcon('heroicon-m-truck')
                ->color('info')
                ->chart([20, 25, 22, 24, 23, 25, $availableCars]),
            
            Stat::make('Inventory Value', 'Rp ' . number_format($totalInventoryValue, 0, ',', '.'))
                ->description('Total available stock value')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('warning'),
            
            Stat::make('Recent Inquiries', $recentContacts)
                ->description('Last 30 days')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('primary'),
        ];
    }
}
