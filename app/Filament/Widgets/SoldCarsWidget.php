<?php

namespace App\Filament\Widgets;

use App\Models\Car;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class SoldCarsWidget extends TableWidget
{
    protected static ?int $sort = 5;

    protected int | string | array $columnSpan = [
        'md' => 8,
        'xl' => 8,
    ];

    public function table(Table $table): Table
    {
        return $table
            ->heading('Unit Terjual Terbaru')
            ->description('Daftar mobil yang sudah terjual untuk membaca performa closing terbaru.')
            ->query(
                Car::query()
                    ->with(['location', 'primaryImage', 'fallbackImage'])
                    ->where('sold', true)
                    ->latest('sold_at')
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
                    ->description(fn (Car $record) => trim($record->make . ' · ' . $record->year, ' · '))
                    ->weight('bold')
                    ->searchable(),

                TextColumn::make('price')
                    ->label('Harga Listing')
                    ->formatStateUsing(fn ($state) => $state ? 'Rp ' . number_format($state, 0, ',', '.') : '—')
                    ->color('success')
                    ->weight('bold'),

                IconColumn::make('featured')
                    ->label('Eksposur')
                    ->boolean()
                    ->trueIcon('heroicon-s-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray')
                    ->alignCenter(),

                TextColumn::make('location.name')
                    ->label('Lokasi')
                    ->color('gray')
                    ->placeholder('—'),

                TextColumn::make('sold_at')
                    ->label('Tanggal Terjual')
                    ->date('d M Y')
                    ->badge()
                    ->color('success'),
            ])
            ->striped()
            ->emptyStateHeading('Belum ada unit terjual')
            ->emptyStateDescription('Saat mobil ditandai terjual, tanggal penjualan akan tercatat dan muncul di sini.')
            ->emptyStateIcon('heroicon-o-check-badge')
            ->paginated(false);
    }
}
