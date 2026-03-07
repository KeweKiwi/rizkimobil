<?php

namespace App\Filament\Widgets;

use App\Models\Car;
use App\Models\Contact;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $availableCount = Car::where('sold', false)->count();
        $inventoryValue = Car::where('sold', false)->sum('price');

        $leadsThisWeek = Contact::where('created_at', '>=', now()->subDays(7))->count();
        $leadsTotal    = Contact::count();

        // STNK expiring within 30 days (including already expired)
        $stnkExpiring = Car::where('sold', false)
            ->whereNotNull('stnk_valid_until')
            ->where('stnk_valid_until', '<=', now()->addDays(30))
            ->count();

        $featuredCount = Car::where('featured', true)->where('sold', false)->count();

        // 7-day lead trend
        $leadTrend = collect(range(6, 0))->map(
            fn ($d) => Contact::whereDate('created_at', now()->subDays($d)->toDateString())->count()
        )->values()->toArray();

        return [
            Stat::make('Stok Tersedia', $availableCount)
                ->description('Rp ' . number_format($inventoryValue, 0, ',', '.') . ' total nilai inventaris')
                ->descriptionIcon('heroicon-m-truck')
                ->color('info'),

            Stat::make('Lead Minggu Ini', $leadsThisWeek)
                ->description($leadsTotal . ' total pertanyaan sepanjang waktu')
                ->descriptionIcon('heroicon-m-chat-bubble-left-ellipsis')
                ->color('success')
                ->chart($leadTrend),

            Stat::make('STNK Segera Habis', $stnkExpiring)
                ->description('Mobil dengan STNK habis dalam 30 hari')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($stnkExpiring > 0 ? 'danger' : 'success'),

            Stat::make('Ditampilkan di Homepage', $featuredCount)
                ->description('Disorot di hero & grid unggulan')
                ->descriptionIcon('heroicon-m-star')
                ->color('warning'),
        ];
    }
}
