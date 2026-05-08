<?php

namespace App\Filament\Widgets;

use App\Models\Car;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class SalesTrendChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = [
        'md' => 8,
        'xl' => 8,
    ];

    protected string $color = 'success';

    protected ?string $heading = 'Performa Penjualan';

    protected ?string $description = 'Baca tren unit terjual dan estimasi omzet dari jangka pendek sampai jangka panjang.';

    protected ?string $maxHeight = '320px';

    public ?string $filter = '12_months';

    protected function getFilters(): ?array
    {
        return [
            '30_days' => '30 hari',
            '90_days' => '90 hari',
            '12_months' => '12 bulan',
            'all_time' => 'Semua tahun',
        ];
    }

    public function getDescription(): string | Htmlable | null
    {
        return match ($this->filter) {
            '30_days' => 'Performa harian selama 30 hari terakhir.',
            '90_days' => 'Performa mingguan selama 90 hari terakhir.',
            'all_time' => 'Performa tahunan dari seluruh data penjualan yang tercatat.',
            default => 'Performa bulanan selama 12 bulan terakhir.',
        };
    }

    protected function getData(): array
    {
        $points = match ($this->filter) {
            '30_days' => $this->buildDailyPoints(30),
            '90_days' => $this->buildWeeklyPoints(13),
            'all_time' => $this->buildYearlyPoints(),
            default => $this->buildMonthlyPoints(12),
        };

        return [
            'datasets' => [
                [
                    'label' => 'Unit terjual',
                    'data' => $points->pluck('units')->all(),
                    'backgroundColor' => 'rgba(34, 197, 94, 0.78)',
                    'borderColor' => '#22c55e',
                    'borderRadius' => 8,
                    'borderSkipped' => false,
                ],
                [
                    'type' => 'line',
                    'label' => 'Omzet listing (juta Rp)',
                    'data' => $points->pluck('revenue')->all(),
                    'borderColor' => '#ef4444',
                    'backgroundColor' => 'rgba(239, 68, 68, 0.12)',
                    'pointBackgroundColor' => '#ef4444',
                    'pointRadius' => 3,
                    'tension' => 0.35,
                    'fill' => false,
                    'yAxisID' => 'revenue',
                ],
            ],
            'labels' => $points->pluck('label')->all(),
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
            'scales' => [
                'x' => [
                    'grid' => [
                        'display' => false,
                    ],
                ],
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                    ],
                ],
                'revenue' => [
                    'beginAtZero' => true,
                    'position' => 'right',
                    'grid' => [
                        'drawOnChartArea' => false,
                    ],
                    'ticks' => [
                        'precision' => 0,
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    private function buildDailyPoints(int $days): Collection
    {
        $start = now()->subDays($days - 1)->startOfDay();
        $records = $this->getSoldRecords($start);
        $grouped = $records->groupBy(fn (Car $car) => $car->sold_at->toDateString());

        return collect(range($days - 1, 0))->map(function (int $offset) use ($grouped) {
            $date = now()->subDays($offset);
            $cars = $grouped->get($date->toDateString(), collect());

            return $this->point($date->translatedFormat('d M'), $cars);
        });
    }

    private function buildWeeklyPoints(int $weeks): Collection
    {
        $start = now()->subWeeks($weeks - 1)->startOfWeek();
        $records = $this->getSoldRecords($start);
        $grouped = $records->groupBy(fn (Car $car) => $car->sold_at->copy()->startOfWeek()->toDateString());

        return collect(range($weeks - 1, 0))->map(function (int $offset) use ($grouped) {
            $weekStart = now()->subWeeks($offset)->startOfWeek();
            $cars = $grouped->get($weekStart->toDateString(), collect());

            return $this->point($weekStart->translatedFormat('d M'), $cars);
        });
    }

    private function buildMonthlyPoints(int $months): Collection
    {
        $start = now()->subMonths($months - 1)->startOfMonth();
        $records = $this->getSoldRecords($start);
        $grouped = $records->groupBy(fn (Car $car) => $car->sold_at->format('Y-m'));

        return collect(range($months - 1, 0))->map(function (int $offset) use ($grouped) {
            $month = now()->subMonths($offset)->startOfMonth();
            $cars = $grouped->get($month->format('Y-m'), collect());

            return $this->point($month->translatedFormat('M Y'), $cars);
        });
    }

    private function buildYearlyPoints(): Collection
    {
        $firstSoldAt = Car::query()
            ->where('sold', true)
            ->whereNotNull('sold_at')
            ->oldest('sold_at')
            ->value('sold_at');

        $startYear = $firstSoldAt
            ? Carbon::parse($firstSoldAt)->year
            : now()->year;

        $records = $this->getSoldRecords(Carbon::create($startYear, 1, 1)->startOfYear());
        $grouped = $records->groupBy(fn (Car $car) => $car->sold_at->format('Y'));

        return collect(range($startYear, now()->year))->map(function (int $year) use ($grouped) {
            $cars = $grouped->get((string) $year, collect());

            return $this->point((string) $year, $cars);
        });
    }

    private function getSoldRecords(Carbon $start): Collection
    {
        return Car::query()
            ->where('sold', true)
            ->whereNotNull('sold_at')
            ->where('sold_at', '>=', $start)
            ->orderBy('sold_at')
            ->get(['sold_at', 'price']);
    }

    private function point(string $label, Collection $cars): array
    {
        return [
            'label' => $label,
            'units' => $cars->count(),
            'revenue' => round(((int) $cars->sum('price')) / 1000000, 1),
        ];
    }
}
