<?php

namespace App\Filament\Widgets;

use App\Models\Car;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class InventoryBodyTypeChart extends ChartWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = [
        'md' => 4,
        'xl' => 4,
    ];

    protected string $color = 'warning';

    protected ?string $heading = 'Mix Stok Siap Jual';

    protected ?string $description = 'Sebaran unit tersedia berdasarkan tipe bodi untuk membaca peluang penawaran.';

    protected ?string $maxHeight = '320px';

    protected function getData(): array
    {
        $rows = Car::query()
            ->where('sold', false)
            ->selectRaw("COALESCE(body_type, 'unknown') as body_type_group, COUNT(*) as total")
            ->groupBy(DB::raw("COALESCE(body_type, 'unknown')"))
            ->orderByDesc('total')
            ->get();

        if ($rows->isEmpty()) {
            return [
                'datasets' => [
                    [
                        'data' => [1],
                        'backgroundColor' => ['rgba(148, 163, 184, 0.35)'],
                        'borderWidth' => 0,
                    ],
                ],
                'labels' => ['Belum ada stok aktif'],
            ];
        }

        return [
            'datasets' => [
                [
                    'data' => $rows->pluck('total')->map(fn ($value) => (int) $value)->all(),
                    'backgroundColor' => [
                        '#f59e0b',
                        '#ef4444',
                        '#22c55e',
                        '#06b6d4',
                        '#8b5cf6',
                        '#f97316',
                        '#14b8a6',
                        '#84cc16',
                        '#64748b',
                        '#a855f7',
                    ],
                    'borderWidth' => 0,
                ],
            ],
            'labels' => $rows->pluck('body_type_group')->map(fn (string $type) => $this->formatBodyTypeLabel($type))->all(),
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                    'labels' => [
                        'boxWidth' => 10,
                        'boxHeight' => 10,
                    ],
                ],
            ],
            'cutout' => '68%',
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    private function formatBodyTypeLabel(string $type): string
    {
        return match ($type) {
            'suv' => 'SUV',
            'mpv' => 'MPV',
            'sedan' => 'Sedan',
            'hatchback' => 'Hatchback',
            'pickup' => 'Pickup',
            'van' => 'Van',
            'coupe' => 'Coupe',
            'convertible' => 'Convertible',
            'wagon' => 'Wagon',
            default => 'Belum diisi',
        };
    }
}
