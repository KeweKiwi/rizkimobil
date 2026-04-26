<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\InventoryBodyTypeChart;
use App\Filament\Widgets\InventoryPriceBandChart;
use App\Filament\Widgets\LatestCarsWidget;
use App\Filament\Widgets\SalesTrendChart;
use App\Filament\Widgets\SoldCarsWidget;
use App\Filament\Widgets\StatsOverview;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Contracts\Support\Htmlable;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Dashboard Operasional';

    public function getSubheading(): string | Htmlable | null
    {
        return 'Pantau unit terjual, estimasi omzet, dan stok siap jual dalam satu tampilan yang lebih relevan untuk admin showroom.';
    }

    public function getColumns(): int | array
    {
        return [
            'md' => 12,
            'xl' => 12,
        ];
    }

    public function getWidgets(): array
    {
        return [
            StatsOverview::class,
            SalesTrendChart::class,
            InventoryBodyTypeChart::class,
            InventoryPriceBandChart::class,
            SoldCarsWidget::class,
            LatestCarsWidget::class,
        ];
    }
}
