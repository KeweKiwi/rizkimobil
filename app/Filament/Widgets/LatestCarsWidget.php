<?php

namespace App\Filament\Widgets;

use App\Models\Car;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class LatestCarsWidget extends TableWidget
{
    protected static ?int $sort = 6;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Stok Siap Didorong')
            ->description('Unit aktif bernilai tinggi dan listing unggulan yang paling layak diprioritaskan untuk penjualan.')
            ->query(
                Car::query()
                    ->with(['location', 'primaryImage', 'fallbackImage'])
                    ->where('sold', false)
                    ->orderByDesc('featured')
                    ->orderByDesc('price')
                    ->latest()
                    ->limit(8)
            )
            ->columns([
                ImageColumn::make('image')
                    ->label('')
                    ->getStateUsing(fn (Car $record) => $record->main_image)
                    ->height(48)
                    ->width(72)
                    ->extraImgAttributes(['class' => 'rounded object-cover']),

                TextColumn::make('title')
                    ->label('Mobil')
                    ->description(fn (Car $record) => $record->make . ' · ' . $record->year)
                    ->weight('bold'),

                TextColumn::make('price')
                    ->label('Harga')
                    ->formatStateUsing(fn ($state) => $state ? 'Rp ' . number_format($state, 0, ',', '.') : '—')
                    ->color('warning')
                    ->weight('bold'),

                IconColumn::make('featured')
                    ->label('Unggulan')
                    ->boolean()
                    ->trueIcon('heroicon-s-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray')
                    ->alignCenter(),

                TextColumn::make('mileage_km')
                    ->label('KM')
                    ->formatStateUsing(fn ($state) => number_format((int) $state, 0, ',', '.') . ' km')
                    ->color('gray'),

                TextColumn::make('stnk_valid_until')
                    ->label('STNK')
                    ->date('d M Y')
                    ->placeholder('Belum diisi')
                    ->color(fn (Car $record) => match (true) {
                        $record->stnk_valid_until === null => 'gray',
                        $record->stnk_valid_until->isPast() => 'danger',
                        $record->stnk_valid_until->diffInDays(now()) <= 30 => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('location.name')
                    ->label('Lokasi')
                    ->color('gray')
                    ->placeholder('—'),
            ])
            ->striped()
            ->emptyStateHeading('Belum ada stok siap jual')
            ->emptyStateDescription('Tambahkan listing aktif agar dashboard penjualan bisa memberi prioritas stok.')
            ->emptyStateIcon('heroicon-o-truck')
            ->paginated(false);
    }
}
