<?php

namespace App\Filament\Widgets;

use App\Models\Car;
use Filament\Widgets\ChartWidget;

class InventoryPriceBandChart extends ChartWidget
{
    protected static ?int $sort = 4;

    protected static bool $isLazy = false;

    protected int | string | array $columnSpan = [
        'md' => 4,
        'xl' => 4,
    ];

    protected string $color = 'info';

    protected ?string $heading = 'Harga Stok Siap Jual';

    protected ?string $description = 'Membantu admin melihat rentang harga yang paling banyak tersedia untuk ditawarkan.';

    protected ?string $maxHeight = '320px';

    protected function getData(): array
    {
        $bands = [
            ['label' => '< Rp 150 Jt', 'min' => null, 'max' => 149999999],
            ['label' => 'Rp 150 - 300 Jt', 'min' => 150000000, 'max' => 300000000],
            ['label' => 'Rp 300 - 500 Jt', 'min' => 300000001, 'max' => 500000000],
            ['label' => '> Rp 500 Jt', 'min' => 500000001, 'max' => null],
            ['label' => 'Harga belum diisi', 'min' => null, 'max' => null, 'null' => true],
        ];

        $data = collect($bands)->map(function (array $band) {
            $query = Car::query()->where('sold', false);

            if (($band['null'] ?? false) === true) {
                return $query->whereNull('price')->count();
            }

            if ($band['min'] !== null) {
                $query->where('price', '>=', $band['min']);
            }

            if ($band['max'] !== null) {
                $query->where('price', '<=', $band['max']);
            }

            return $query->count();
        });

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah unit',
                    'data' => $data->all(),
                    'backgroundColor' => [
                        'rgba(245, 158, 11, 0.85)',
                        'rgba(249, 115, 22, 0.85)',
                        'rgba(239, 68, 68, 0.85)',
                        'rgba(59, 130, 246, 0.85)',
                        'rgba(148, 163, 184, 0.75)',
                    ],
                    'borderRadius' => 10,
                    'borderSkipped' => false,
                ],
            ],
            'labels' => collect($bands)->pluck('label')->all(),
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
