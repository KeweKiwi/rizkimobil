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
            Stat::make('Available Stock', $availableCount)
                ->description('Rp ' . number_format($inventoryValue, 0, ',', '.') . ' total value')
                ->descriptionIcon('heroicon-m-truck')
                ->color('info'),

            Stat::make('Leads This Week', $leadsThisWeek)
                ->description($leadsTotal . ' total inquiries all time')
                ->descriptionIcon('heroicon-m-chat-bubble-left-ellipsis')
                ->color('success')
                ->chart($leadTrend),

            Stat::make('STNK Expiring Soon', $stnkExpiring)
                ->description('Cars expiring within 30 days')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($stnkExpiring > 0 ? 'danger' : 'success'),

            Stat::make('Featured on Homepage', $featuredCount)
                ->description('Highlighted in hero & featured section')
                ->descriptionIcon('heroicon-m-star')
                ->color('warning'),
        ];
    }
}
