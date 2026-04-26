<?php

namespace App\Filament\Widgets;

use App\Models\Car;
use Filament\Widgets\ChartWidget;

class SalesTrendChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = [
        'md' => 8,
        'xl' => 8,
    ];

    protected string $color = 'success';

    protected ?string $heading = 'Tren Unit Terjual';

    protected ?string $description = 'Unit yang sudah terjual berdasarkan tanggal penjualan listing.';

    protected ?string $maxHeight = '320px';

    public ?string $filter = '30';

    protected function getFilters(): ?array
    {
        return [
            '7' => '7 hari',
            '14' => '14 hari',
            '30' => '30 hari',
        ];
    }

    protected function getData(): array
    {
        $days = (int) ($this->filter ?: 30);

        $points = collect(range($days - 1, 0))
            ->map(function (int $offset) {
                $date = now()->subDays($offset);

                return [
                    'label' => $date->translatedFormat('d M'),
                    'value' => Car::query()
                        ->where('sold', true)
                        ->whereDate('sold_at', $date->toDateString())
                        ->count(),
                ];
            });

        return [
            'datasets' => [
                [
                    'label' => 'Unit terjual',
                    'data' => $points->pluck('value')->all(),
                    'backgroundColor' => 'rgba(34, 197, 94, 0.78)',
                    'borderColor' => '#22c55e',
                    'borderRadius' => 8,
                    'borderSkipped' => false,
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
                    'display' => false,
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
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
