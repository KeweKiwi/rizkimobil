<?php

namespace App\Filament\Widgets;

use App\Models\Car;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected ?string $heading = 'Snapshot Penjualan';

    protected ?string $description = 'Ringkasan omzet, performa 12 bulan, dan stok siap jual berdasarkan data listing saat ini.';

    protected int | array | null $columns = [
        'md' => 2,
        'xl' => 4,
    ];

    protected function getStats(): array
    {
        $availableCount = Car::where('sold', false)->count();
        $soldCount = Car::where('sold', true)->count();
        $totalInventoryCount = $availableCount + $soldCount;

        $inventoryValue = (int) Car::where('sold', false)->sum('price');
        $soldValue = (int) Car::where('sold', true)->sum('price');

        $soldThisMonth = Car::where('sold', true)
            ->where('sold_at', '>=', now()->startOfMonth())
            ->count();

        $soldLast12Months = Car::where('sold', true)
            ->whereBetween('sold_at', [
                now()->subMonths(11)->startOfMonth(),
                now()->endOfDay(),
            ])
            ->count();

        $previous12MonthsSold = Car::where('sold', true)
            ->whereBetween('sold_at', [
                now()->subMonths(23)->startOfMonth(),
                now()->subMonths(12)->endOfMonth(),
            ])
            ->count();

        $stnkExpiring = Car::where('sold', false)
            ->whereNotNull('stnk_valid_until')
            ->where('stnk_valid_until', '<=', now()->addDays(30))
            ->count();

        $soldTrend = collect(range(11, 0))
            ->map(fn (int $monthOffset) => Car::where('sold', true)->whereBetween('sold_at', [
                now()->subMonths($monthOffset)->startOfMonth(),
                now()->subMonths($monthOffset)->endOfMonth(),
            ])->count())
            ->values()
            ->all();

        $revenueTrend = collect(range(11, 0))
            ->map(fn (int $monthOffset) => (int) Car::where('sold', true)->whereBetween('sold_at', [
                now()->subMonths($monthOffset)->startOfMonth(),
                now()->subMonths($monthOffset)->endOfMonth(),
            ])->sum('price'))
            ->values()
            ->all();

        $availableTrend = collect(range(11, 0))
            ->map(fn (int $monthOffset) => Car::where('sold', false)->whereBetween('created_at', [
                now()->subMonths($monthOffset)->startOfMonth(),
                now()->subMonths($monthOffset)->endOfMonth(),
            ])->count())
            ->values()
            ->all();

        $sellThroughTrend = collect(range(11, 0))
            ->map(fn (int $monthOffset) => Car::where('sold', true)->where('sold_at', '<=', now()->subMonths($monthOffset)->endOfMonth())->count())
            ->values()
            ->all();

        $sellThroughRate = $totalInventoryCount > 0
            ? round(($soldCount / $totalInventoryCount) * 100)
            : 0;

        return [
            Stat::make('Estimasi Omzet Terjual', $this->formatRupiahCompact($soldValue))
                ->description($soldCount . ' unit sudah terjual')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success')
                ->chart($revenueTrend),

            Stat::make('Terjual 12 Bulan', $soldLast12Months)
                ->description($soldThisMonth . ' unit bulan ini · ' . $this->formatPeriodComparison($soldLast12Months, $previous12MonthsSold))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('warning')
                ->chart($soldTrend),

            Stat::make('Stok Siap Jual', $availableCount)
                ->description($this->formatRupiahCompact($inventoryValue) . ' nilai listing aktif')
                ->descriptionIcon('heroicon-m-truck')
                ->color('info')
                ->chart($availableTrend),

            Stat::make('Rasio Terjual', $sellThroughRate . '%')
                ->description($stnkExpiring > 0
                    ? $stnkExpiring . ' stok aktif perlu cek STNK sebelum ditawarkan'
                    : 'Dokumen stok aktif aman untuk ditawarkan'
                )
                ->descriptionIcon('heroicon-m-check-badge')
                ->color($sellThroughRate >= 50 ? 'success' : 'gray')
                ->chart($sellThroughTrend),
        ];
    }

    private function formatPeriodComparison(int $current, int $previous): string
    {
        if ($previous === 0) {
            return $current > 0
                ? 'mulai tercatat dibanding periode sebelumnya'
                : 'belum ada unit terjual dalam periode ini';
        }

        $difference = $current - $previous;
        $change = round((abs($difference) / $previous) * 100);

        if ($difference === 0) {
            return 'stabil dibanding 12 bulan sebelumnya';
        }

        $direction = $difference > 0 ? 'naik' : 'turun';

        return $change . '% ' . $direction . ' dibanding 12 bulan sebelumnya';
    }

    private function formatRupiahCompact(int $amount): string
    {
        if ($amount >= 1000000000) {
            return 'Rp ' . number_format($amount / 1000000000, 1, ',', '.') . ' M';
        }

        if ($amount >= 1000000) {
            return 'Rp ' . number_format($amount / 1000000, 0, ',', '.') . ' Jt';
        }

        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}
